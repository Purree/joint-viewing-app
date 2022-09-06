<template>
    <div class="is-relative box">
        <div v-if="chatPending">
            <o-loading overlayClass="is-transparent" :full-page="false" :active="chatPending"
                       :can-cancel="false"></o-loading>
        </div>
        <div class="h-100" v-else>
            <div class="is-sticky chat-control-buttons">
                <div class="is-flex">
                    <o-button iconRightClass="regular" icon-right="close" @click="$emit('closeChat')"></o-button>
                    <o-button iconRightClass="regular" icon-right="arrow-down" v-if="showScrollDownButton"
                              @click="scrollToLastMessage"></o-button>
                    <o-button iconRightClass="regular" v-if="is_chat_move_active"
                              :icon-right="isChatBelow ? 'arrow-right' : 'arrow-left'"
                              @click="$emit('changeChatPosition')"></o-button>
                    <div class="box is-relative" v-if="addMessagePending">
                        <o-loading overlayClass="is-transparent" :full-page="false" :active="addMessagePending"
                                   :can-cancel="false"></o-loading>
                    </div>
                </div>
            </div>
            <div class="messages" ref="messages"
                 :class="{'is-flex is-justify-content-center is-align-items-center has-text-grey-light': messages.length === 0}">
                <chat-message v-for="message in messages"
                              v-if="messages.length > 0"
                              :message="message"
                              :is-sent-by-current-user="message.user.id === this.user.id"></chat-message>
                <div v-else class="has-text-centered">
                    There are no messages yet, but you can send message using the form below.
                </div>
            </div>
            <form @submit.prevent="usePending(sendMessage, 'sendMessagePending')"
                  class="send-message-form box is-flex is-sticky">
                <div class="w-100 is-radiusless">
                    <o-input v-model="userMessage"
                             required
                             :disabled="sendMessagePending"
                             rootClass="is-radiusless h-100"
                             class="is-radiusless h-100"
                             placeholder="Hello!"></o-input>
                </div>
                <div>
                    <o-button nativeType="submit" class="is-radiusless h-100"
                              icon-right="paper-plane"
                              :class="{'is-loading': sendMessagePending}"
                              :disabled="sendMessagePending || userMessage.length === 0"></o-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import ChatMessage from "@/components/room/chat/Message";
import {mapState} from "vuex";
import errorsHelper from "@/mixins/errors";
import replaceDataInUri from "@/helpers/replaceDataInUri";
import {API_GET_ALL_MESSAGES_URL, API_SEND_MESSAGE_URL} from "@/api/chat";
import usePending from "@/mixins/usePending";
import broadcastConnections from "@/mixins/broadcastConnections";
import apiRequest from "@/helpers/apiRequest";

export default {
    name: "Chat",
    components: {ChatMessage},
    emits: ['closeChat', 'changeChatPosition'],
    mixins: [usePending],
    props: {
        room: {
            type: Object,
            required: true
        },
        isChatBelow: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            userMessage: "",
            showScrollDownButton: false,
            chatPending: true,
            sendMessagePending: false,
            addMessagePending: false,
            messages: [],
            errors: [],
            totalMessagePages: 0,
            currentMessagePage: 0,
            is_chat_move_active: true
        };
    },
    computed: {
        ...mapState('auth', ['user'])
    },
    methods: {
        getMessages(page = 1) {
            return apiRequest(API_GET_ALL_MESSAGES_URL, {'roomId': this.room.id}, {params: {'page': page}})
                .then(response => {
                    this.totalMessagePages = response.data.pagination.total_pages;
                    this.currentMessagePage = response.data.pagination.current_page;
                    return response;
                }).catch(errors => {
                    this.errors = errorsHelper.methods.getFromResponse(errors);
                    errorsHelper.methods.openResponseNotification(errors);
                });
        },
        sendMessage() {
            return apiRequest(API_SEND_MESSAGE_URL, {'roomId': this.room.id}, {'message': this.userMessage})
                .then(() => {
                    this.userMessage = '';
                }).catch(errors => {
                    this.errors = errorsHelper.methods.getFromResponse(errors);
                    errorsHelper.methods.openResponseNotification(errors);
                });

        },
        handleMessagesScroll() {
            this.showScrollDownButton = !this.checkIsChatScrolledDown();

            if (
                (this.$refs.messages.scrollHeight - this.$refs.messages.clientHeight) / 5 >= this.$refs.messages.scrollTop
                && this.currentMessagePage < this.totalMessagePages && !this.addMessagePending
            ) {
                this.addMessagePending = true;
                let scrollDifference = 0;

                this.getMessages(this.currentMessagePage + 1)
                    .then((response) => {
                        scrollDifference = this.$refs.messages.scrollHeight - this.$refs.messages.scrollTop
                        this.messages.unshift(...response.data.data)
                        this.addMessagePending = false;
                    })
                    .then(() => {
                        this.$nextTick(() => {
                            this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight - scrollDifference;
                        });
                    });
            }
        },
        scrollToLastMessage() {
            this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight;
        },
        checkIsChatScrolledDown() {
            return this.$refs.messages.scrollHeight -
                this.$refs.messages.clientHeight -
                this.$refs.messages.lastElementChild.clientHeight - 10 <= this.$refs.messages.scrollTop;
        },
        checkIsWindowSmall(windowWidth = document.body.clientWidth) {
            this.is_chat_move_active = windowWidth > 590;
        },
    },
    mounted() {
        this.getMessages().then((response) => {
            this.messages = response.data.data;
            this.chatPending = false;
        }).catch(() => {
            this.chatPending = false;
        }).then(() => {
            this.$refs.messages.addEventListener('scroll', this.handleMessagesScroll);
            this.scrollToLastMessage();
        });

        this.checkIsWindowSmall()
        window.addEventListener('resize', () => {this.checkIsWindowSmall()})

        broadcastConnections.methods.connectToRoom(this.room.id)
            .listen('MessageSent', response => {
                this.messages.push(response.message);

                this.$nextTick(() => {
                    if (this.checkIsChatScrolledDown()) {
                        this.scrollToLastMessage();
                    }
                });
            });
    },
}
</script>

<style scoped lang="scss">
$box-border-size: 1.25rem;
$input-height: 48px;
$input-margin: 15px;


.chat {
    margin-left: 10px;
    max-width: calc(50% - 10px);
    width: calc(50% - 10px);
    padding-bottom: 0;
    padding-right: 0;
}

.messages {
    overflow-x: hidden;
    overflow-y: scroll;
    height: calc(100% - $input-height + $box-border-size - $input-margin);
    padding-right: $box-border-size;
}

.send-message-form {
    height: $input-height;
    margin-left: -$box-border-size;
    margin-top: $input-margin;
    padding: 0;
}

.chat-control-buttons {
    top: -$box-border-size;
    margin-left: -$box-border-size;
    margin-top: -$box-border-size;
    height: 0;
}
</style>

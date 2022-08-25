<template>
    <div class="is-relative box">
        <div v-if="chatPending">
            <o-loading overlayClass="is-transparent" :full-page="false" :active="chatPending" :can-cancel="false"></o-loading>
        </div>
        <div class="h-100" v-else>
            <div class="is-sticky close-chat-button">
                <o-button iconRightClass="regular" icon-right="close" @click="$emit('closeChat')"></o-button>
            </div>
            <div class="messages">
                <chat-message v-for="message in messages" :message="message"
                              :is-sent-by-current-user="message.user.id === this.user.id"></chat-message>
            </div>
            <div class="send-message-form box is-flex is-sticky">
                <div class="w-100 is-radiusless">
                    <o-input v-model="userMessage"
                             required
                             rootClass="is-radiusless h-100"
                             class="is-radiusless h-100"
                             placeholder="Hello!"></o-input>
                </div>
                <div>
                    <o-button class="is-radiusless h-100" icon-right="paper-plane" @click=""></o-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ChatMessage from "@/components/room/Chat/Message";
import {mapState} from "vuex";
import errorsHelper from "@/mixins/errors";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import {API_GET_ALL_MESSAGES_URL, API_SEND_MESSAGE_URL} from "@/api/chat";

export default {
    name: "Chat",
    components: {ChatMessage},
    props: {
        room: {
            type: Object,
            required: true
        }
    },
    emits: ['closeChat'],
    data() {
        return {
            userMessage: "",
            chatPending: true,
            messages: [],
            errors: []
        };
    },
    computed: {
        ...mapState('auth', ['user'])
    },
    methods: {
        getMessages() {
            return axios.get(replaceDataInUri(API_GET_ALL_MESSAGES_URL, {'roomId': this.room.id}))
                .then(response => {
                    this.messages = response.data;
                }).catch(errors => {
                    this.errors = errorsHelper.methods.getFromResponse(errors);
                    errorsHelper.methods.openResponseNotification(errors);
                });
        },
        sendMessage(message) {
            return axios.get(replaceDataInUri(API_SEND_MESSAGE_URL, {'roomId': this.room.id}), {'message': message})
        }
    },
    mounted() {
        this.getMessages().then(() => {
            this.chatPending = false;
        });
    }
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

.close-chat-button {
    top: -$box-border-size;
    margin-left: -$box-border-size;
    margin-top: -$box-border-size;
    height: 0;
}
</style>

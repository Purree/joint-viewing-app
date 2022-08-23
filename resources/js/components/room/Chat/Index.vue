<template>
    <div class="is-relative box">
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
</template>

<script>
import ChatMessage from "@/components/room/Chat/Message";
import {mapState} from "vuex";

export default {
    name: "Chat",
    components: {ChatMessage},
    emits: ['closeChat'],
    data() {
        return {
            userMessage: "",
            messages: [
                {
                    id: 1,
                    message: "test",
                    created_at: Date.now(),
                    user: {
                        id: 1,
                        name: "test",
                    },
                },
                {
                    id: 2,
                    message: "test",
                    created_at: Date.now(),
                    user: {
                        id: 3,
                        name: "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
                    },
                },
                {
                    id: 3,
                    message: "test",
                    created_at: Date.now(),
                    user: {
                        id: 4,
                        name: "test",
                    },
                },
                {
                    id: 4,
                    message: "test",
                    created_at: Date.now(),
                    user: {
                        id: 1,
                        name: "test",
                    },
                },
                {
                    id: 5,
                    message: "test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test",
                    created_at: Date.now(),
                    user: {
                        id: 1,
                        name: "test",
                    },
                },
                {
                    id: 6,
                    message: "test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test",
                    created_at: Date.now(),
                    user: {
                        id: 6,
                        name: "test",
                    },
                },
                {
                    id: 7,
                    message: "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
                    created_at: Date.now(),
                    user: {
                        id: 4,
                        name: "test",
                    },
                },
                {
                    id: 8,
                    message: "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
                    created_at: Date.now(),
                    user: {
                        id: 1,
                        name: "test",
                    },
                },
                {
                    id: 9,
                    message: "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
                    created_at: Date.now(),
                    user: {
                        id: 1,
                        name: "test",
                    },
                }
            ],
        };
    },
    computed: {
        ...mapState('auth', ['user'])
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

.close-chat-button {
    top: -$box-border-size;
    margin-left: -$box-border-size;
    margin-top: -$box-border-size;
    height: 0;
}
</style>

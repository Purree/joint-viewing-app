<template>
    <div class="chat-message is-flex is-align-items-flex-end" :class="{'is-justify-content-end' : this.isSentByCurrentUser}">
        <user-avatar v-if="!this.isSentByCurrentUser" :avatar-path="this.message.user?.avatar" class="sender-avatar"/>
        <div class="is-flex is-flex-direction-column message-text-container"
             :class="this.isSentByCurrentUser ? 'is-justify-content-flex-end is-align-items-flex-end' : 'another-user-message-container'">
            <div class="message-text"
                  :class="this.isSentByCurrentUser ? 'current-user-message-text' : 'another-user-message-text'"
            >
                <span>
                    {{ this.message.message }}
                </span>
                <div class="message-sent-at">Sent {{ formatDate(this.message.created_at) }}</div>
            </div>
            <div class="sender-name is-ellipsis" v-if="!isSentByCurrentUser">
                <span>{{ this.message.user.name }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import asset from "@/mixins/asset";
import formatDate from "@/mixins/formatDate";
import UserAvatar from "@/components/UserAvatar";

export default {
    name: "ChatMessage",
    components: {UserAvatar},
    mixins: [asset, formatDate],
    props: {
        message: {
            type: Object,
            required: true,
            default: () => ({
                id: 1,
                message: "test",
                created_at: Date.now(),
                user: {
                    id: 1,
                    name: "test",
                },
            })
        },
        isSentByCurrentUser: {
            type: Boolean,
            required: true,
            default: false,
        },
    },
}
</script>

<style scoped lang="scss">
$message-min-width: 15rem;
$message-max-width: 100%;

.message-text-container {
    width: 50%;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    line-height: 1rem;
    word-wrap: break-word;
}

.message-text {
    min-width: $message-min-width;
    max-width: $message-max-width;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
}

.current-user-message-text {
    border-bottom-right-radius: 0;
    background-color: rgb(37 99 235);
    color: white;
}

.another-user-message-text {
    border-bottom-left-radius: 0;
    background-color: rgb(209 213 219);
    color: black;
}

.sender-avatar {
    margin-right: 5px;
}

.sender-name {
    min-width: $message-min-width;
    max-width: $message-max-width;
}

.message-sent-at {
    font-size: 0.51rem;
    word-wrap: normal;
}
</style>

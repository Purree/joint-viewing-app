<template>
    <div class="chat-message">
        <div class="is-flex message-text-container"
             :class="{'is-justify-content-flex-end': this.isSentByCurrentUser}">
            <span class="message-text"
                  :class="{'current-user-message-text': this.isSentByCurrentUser, 'another-user-message-test': !this.isSentByCurrentUser}"
            >
                {{ this.message.message }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: "ChatMessage",
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

<style scoped>
.message-text-container {
    margin-top: 0.5rem;
    font-size: 0.75rem;
    line-height: 1rem;
    word-wrap: break-word;
}

.message-text {
    max-width: 15rem;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
}

.current-user-message-text {
    border-bottom-right-radius: 0;
    background-color: rgb(37 99 235);
    color: white;
}

.another-user-message-test {
    border-bottom-left-radius: 0;
    background-color: rgb(209 213 219);
    color: black;
}
</style>

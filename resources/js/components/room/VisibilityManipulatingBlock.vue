<template>
    <div class="is-absolute buttons-block is-flex" :class="(is_chat_closed && is_queue_closed) ? 'all_closed' : ''">
        <o-button v-if="is_chat_closed" icon-right="comment-dots"
                  @click="$emit('openChat')"
                  class="open-button"></o-button>

        <o-button v-if="is_queue_closed" icon-right="arrow-down-a-z"
                  @click="$emit('openQueue')"
                  class="open-button" :class="!is_chat_closed ? 'open-queue-on-chat-button' : ''"></o-button>
    </div>
</template>

<script>
export default {
    name: "VisibilityManipulatingBlock",
    emits: ['openChat', 'openQueue'],
    props: {
        is_chat_closed: {
            type: Boolean,
            default: false
        },
        is_queue_closed: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>
    .buttons-block {
        width: 0;
    }
    .open-button, .all_closed .open-button {
        right: calc(1.25rem * 4);
    }
    .open-queue-on-chat-button {
        right: calc(1.25rem * 2);
    }
    @media (max-width: 600px) {
        .open-button {
            left: 0;
        }
    }
</style>

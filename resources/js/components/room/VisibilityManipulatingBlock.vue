<template>
    <div class="is-absolute is-flex buttons-block">
        <o-button v-if="is_chat_closed" icon-right="comment-dots"
                  @click="$emit('openChat')"></o-button>

        <o-button v-if="is_orders_closed" icon-right="arrow-down-a-z"
                  @click="$emit('openOrders')"></o-button>
    </div>
</template>

<script>
export default {
    name: "VisibilityManipulatingBlock",
    emits: ['openChat', 'openOrders'],
    props: {
        is_chat_closed: {
            type: Boolean,
            default: false
        },
        is_orders_closed: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>
    .buttons-block {
        right: 0;
    }
</style>

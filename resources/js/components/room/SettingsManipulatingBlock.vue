<template>
    <div class="is-absolute is-flex buttons-block">
        <o-button v-if="is_chat_closed" icon-right="comment-dots"
                  @click="$emit('openChat')"></o-button>

        <o-button v-if="is_orders_closed" icon-right="arrow-down-a-z"
                  @click="$emit('openOrders')"></o-button>

        <o-button v-if="is_user_owner" icon-right="gear"
                  @click="$emit('openSettings')"></o-button>

        <o-button icon-right="people-group"
                  @click="$emit('openUsers')"></o-button>
    </div>
</template>

<script>
export default {
    name: 'RoomSettingsManipulatingBlock',
    emits: ['openChat', 'openOrders', 'openSettings', 'openUsers'],
    props: {
        is_chat_closed: {
            type: Boolean,
            default: false
        },
        is_orders_closed: {
            type: Boolean,
            default: false
        },
        is_user_owner: {
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

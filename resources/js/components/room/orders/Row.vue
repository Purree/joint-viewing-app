<template>
    <div class="column box orders-column is-overflow-hidden is-radiusless">
        <div class="is-flex is-justify-content-space-between is-align-items-center">
            <div class="orders-column-text-box is-overflow-hidden">
                <div>
                    <a :href="this.order.video_url" target="_blank">
                        {{ this.order.video_url }}
                    </a>
                </div>
                <div>Ordered by {{ this.order.customer.name }}</div>
            </div>
            <o-button @click="$emit('deleteOrder', this.order.id)" class="delete-order-button" v-if="canControl"
                      variant="danger" icon-right="trash-can" :class="{'is-loading': deletePending}"
                      :disabled="deletePending"></o-button>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrdersRow",
    emits: ["deleteOrder"],
    props: {
        order: {
            type: Object,
            default: () => ({
                "video_url": 'https://test.test',
                "customer": {
                    "id": 1,
                    "name": 'Test user',
                },
            })
        },
        deletePending: {
            type: Boolean,
            default: false
        },
        canControl: {
            type: Boolean,
            default: false
        },
    }
}
</script>

<style lang="scss" scoped>
.orders-column {
    white-space: nowrap;

    &:not(:last-child) {
        margin-bottom: 10px;
    }
}

.orders-column-text-box {
    max-width: 100%;
    white-space: nowrap;
}

.delete-order-button {
    margin-left: 5px;
}
</style>

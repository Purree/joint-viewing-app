<template>
    <div class="column box queue-column is-radiusless">
        <div class="is-flex is-justify-content-space-between is-align-items-center">
            <div class="queue-column-text-box">
                <div>
                    <a :href="this.order.video_url">
                        {{ this.order.video_url }}
                    </a>
                </div>
                <div>Ordered by {{ this.order.customer.name }}</div>
            </div>
            <o-button class="delete-order-button" v-if="canControl" variant="danger" icon-right="trash-can"></o-button>
        </div>
    </div>
</template>

<script>
export default {
    name: "QueueRow",
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
        canControl: {
            type: Boolean,
            default: false
        },
    }
}
</script>

<style lang="scss" scoped>
.queue-column {
    white-space: nowrap;
    overflow: hidden;
    &:not(:last-child) {
        margin-bottom: 10px;
    }
}
.queue-column-text-box {
    max-width: 100%;
    overflow: hidden;
    white-space: nowrap;
}
.delete-order-button {
    margin-left: 5px;
}
</style>

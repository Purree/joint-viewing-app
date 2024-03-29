<template>
    <div class="orders-content is-relative box">
        <div class="orders-content" v-if="!ordersPending">
            <div class="is-sticky close-orders-button translucent-element">
                <o-button iconRightClass="regular" icon-right="close" @click="$emit('closeOrders')"></o-button>
            </div>
            <div class="is-flex is-flex-direction-column h-100"
                 :class="orders.length === 0 ?
                 'is-justify-content-center is-align-items-center':
                 'is-justify-content-space-between'">

                <transition-group v-if="orders.length !== 0" name="slide-next" tag="div" class="orders-container">
                    <orders-row  v-for="order in orders"
                                :key="order.id"
                                :can-control="user.id === order.customer.id || this.canControl"
                                :order="order"
                                :delete-pending="this.ordersToDelete.includes(order.id)"
                                @delete-order="deleteOrder"></orders-row>
                </transition-group>
                <div class="mb-4 has-text-centered" v-else>
                    There are no orders
                    yet{{ this.canControl ? ', but you can add a video using the form below.' : '.' }}
                </div>

                <form v-if="canControl" @submit.prevent="usePending(addOrder, 'addOrderPending')"
                      class="w-100 is-flex">
                    <div class="w-100 is-radiusless">
                        <o-input v-model="requestedUrl"
                                 required
                                 clearable
                                 class="is-radiusless"
                                 placeholder="https://youtube.com/watch?v=dQw4w9WgXcQ"
                                 type="url"
                                 :disabled="addOrderPending"></o-input>
                    </div>
                    <div>
                        <o-button class="is-radiusless" icon-right="plus"
                                  :class="{'is-loading': addOrderPending}"
                                  nativeType="submit"
                                  :disabled="addOrderPending || requestedUrl.length === 0"></o-button>
                    </div>
                </form>
            </div>
        </div>
        <div v-else>
            <o-loading overlayClass="is-transparent" :full-page="false" :active="ordersPending"
                       :can-cancel="false"></o-loading>
        </div>
    </div>
</template>

<script>
import OrdersRow from '@/components/room/orders/Row'
import { mapState } from 'vuex'
import errorsHelper from '@/mixins/errors'
import { API_ADD_ORDER_URL, API_DELETE_ORDER_URL, API_GET_ALL_ORDERS_URL } from '@/api/orders'
import broadcastConnections from '@/mixins/broadcastConnections'
import usePending from '@/mixins/usePending'
import apiRequest from '@/helpers/apiRequest'

export default {
    name: 'Orders',
    components: { OrdersRow },
    mixins: [usePending],
    emits: ['closeOrders', 'changeCurrentVideo'],
    props: {
        canControl: {
            type: Boolean,
            default: false
        },
        room: {
            type: Object,
            required: true
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    },
    data() {
        return {
            requestedUrl: '',
            orders: [],
            ordersPending: true,
            ordersToDelete: [],
            addOrderPending: false
        }
    },
    methods: {
        getOrders() {
            return apiRequest(API_GET_ALL_ORDERS_URL, { roomId: this.room.id })
                .then(response => {
                    return response
                }).catch(errors => {
                    this.errors = errorsHelper.methods.getFromResponse(errors)
                    errorsHelper.methods.openResponseNotification(errors)
                })
        },
        addOrder() {
            return apiRequest(API_ADD_ORDER_URL, { roomId: this.room.id }, { video_url: this.requestedUrl })
                .then(() => {
                    this.requestedUrl = ''
                }).catch(errors => {
                    this.errors = errorsHelper.methods.getFromResponse(errors)
                    errorsHelper.methods.openResponseNotification(errors)
                })
        },
        deleteOrder(orderId) {
            if (this.ordersToDelete.includes(orderId)) {
                return
            }
            this.ordersToDelete.push(orderId)

            return apiRequest(API_DELETE_ORDER_URL, { roomId: this.room.id, orderId })
                .then((response) => {
                    return response
                }).catch(errors => {
                    this.errors = errorsHelper.methods.getFromResponse(errors)
                    errorsHelper.methods.openResponseNotification(errors)
                }).then(() => {
                    this.ordersToDelete = this.ordersToDelete.filter(id => id !== orderId)
                })
        }
    },
    watch: {
        orders(orders) {
            this.$emit('changeCurrentVideo', orders[0])
        }
    },
    mounted() {
        this.getOrders().then((response) => {
            this.orders = response.data
        }).catch(() => {
        }).then(() => {
            this.ordersPending = false
        })

        broadcastConnections.methods.connectToRoom(this.room.id)
            .listen('OrderAdd', response => {
                this.orders.push(response.order)
            })
            .listen('OrderDelete', response => {
                this.orders = this.orders.filter(order => order.id !== response.order.id)
            })
            .listen('ChangePlayingVideo', response => {
                this.$emit('changeCurrentVideo', response.order)
            })
    }
}
</script>

<style scoped>
.orders-content {
    margin-top: 10px;
    padding: 0;
    height: 100%;
}

.orders-container {
    overflow-y: scroll;
    overflow-x: hidden;
}

.close-orders-button {
    height: 0;
    top: 0;
}
</style>

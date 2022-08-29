<template>
    <div v-if="is_loaded" class="h-100">
        <div class="activity-block is-flex is-relative"
             :class="{'fullscreen h-100 chat-below': is_orders_closed}">
            <player class="player"></player>
            <chat :can-control="can_manipulate_room" :room="current_room" v-if="!is_chat_closed"
                  @close-chat="manipulateChatVisibility" class="chat"></chat>
            <visibility-manipulating-block v-if="is_chat_closed || is_orders_closed"
                                           @open-chat="manipulateChatVisibility"
                                           @open-orders="manipulateOrdersVisibility"
                                           :is_chat_closed="is_chat_closed"
                                           :is_orders_closed="is_orders_closed"></visibility-manipulating-block>
        </div>
        <div class="orders-block" v-if="!is_orders_closed">
            <orders :room="current_room" :can-control="can_manipulate_room" @closeOrders="manipulateOrdersVisibility"></orders>
        </div>
    </div>
    <div v-else>
        <o-loading overlayClass="is-transparent" :full-page="true" :active="!is_loaded" :can-cancel="false"></o-loading>
    </div>
</template>

<script>
import {API_GET_ROOM_DATA_BY_LINK_URL} from "@/api/rooms";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import errorsHelper from "@/mixins/errors.js";
import {mapState} from "vuex";
import Player from "@/components/room/Player";
import Chat from "@/components/room/Chat/Index";
import Orders from "@/components/room/Orders/Index";
import VisibilityManipulatingBlock from "@/components/room/VisibilityManipulatingBlock";
import broadcastConnections from "@/mixins/broadcastConnections";

export default {
    name: "Index",
    components: {VisibilityManipulatingBlock, Orders, Player, Chat},
    data() {
        return {
            is_loaded: false,
            room: {},
            users: [],
            can_manipulate_room: false,
            is_chat_closed: false,
            is_orders_closed: false,
        }
    },
    async beforeCreate() {
        try {
            await axios.get(replaceDataInUri(API_GET_ROOM_DATA_BY_LINK_URL, {'roomLink': this.$route.params.link}))
                .then((response) => {
                    this.room = response.data;
                })
        } catch (error) {
            errorsHelper.methods.openResponseNotification(error)

            if (error.response.status === 404) {
                return this.$router.push('/404');
            }
        }

        if (this.current_room?.id !== this.room.id) {
            errorsHelper.methods.openNotification('You are not in this room');

            await this.$router.push({'name': 'RoomEntrance', 'params': {'id': this.room.id}});
        }

        broadcastConnections.methods.connectToRoom(this.room.id)
            .here((users) => {
                this.users = users;
            })
            .joining((user) => {
                this.users.push(user);
            })
            .leaving((user) => {
                this.users = this.users.filter(u => (u.id !== user.id))
            });

        this.can_manipulate_room = !!this.current_room.can_everyone_control || this.room.owner.id === this.user.id;
        this.is_loaded = true;
    },
    methods: {
        manipulateChatVisibility() {
            this.is_chat_closed = !this.is_chat_closed
        },
        manipulateOrdersVisibility() {
            this.is_orders_closed = !this.is_orders_closed
        }
    },
    computed: {
        ...mapState('auth', ['user']),
        ...mapState('rooms', ['current_room']),
    }
}
</script>

<style lang="scss" scoped>
.activity-block {
    height: 70%;
}

.orders-block {
    height: 30%;
}

.fullscreen {
    height: 100%;

    & .chat {
        margin-bottom: 0 !important;
    }
}

.chat-below {
    flex-direction: column;
}

.chat-below .chat {
    margin-top: 20px;
    margin-left: 0;
    max-width: 100%;
    max-height: 100%;

    & {
        width: 100%;
        height: calc(50% - 20px);
    }
}

@media (max-width: 600px) {
    .activity-block {
        flex-direction: column;
    }
    .chat {
        margin-top: 20px;
        margin-left: 0;
        max-width: 100%;

        & {
            width: 100%;
            height: calc(50% - 20px);
        }
    }
}
</style>

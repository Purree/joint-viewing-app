<template>
    <div v-if="is_loaded" class="h-100">
        <div class="activity-block is-flex is-relative"
             :class="{'fullscreen h-100': is_orders_closed, 'chat-below': is_chat_below}">
            <player :room="room" :host="host_id" :can-control="can_manipulate_room" :video-id="videoId" class="player"></player>
            <transition name="horizontal-downsize">
                <chat :can-control="can_manipulate_room" :room="room" v-if="!is_chat_closed"
                      :is-chat-below="is_chat_below"
                      @change-chat-position="is_chat_below = !is_chat_below"
                      @close-chat="manipulateChatVisibility" class="chat"></chat>
            </transition>
            <room-settings-manipulating-block @open-chat="manipulateChatVisibility"
                                              @open-orders="manipulateOrdersVisibility"
                                              @open-settings="openSettingsModal"
                                              @open-users="openMembersModal"
                                              :is_chat_closed="is_chat_closed"
                                              :is_orders_closed="is_orders_closed"
                                              :is_user_owner="user.id === room.owner.id"></room-settings-manipulating-block>
        </div>

        <transition name="vertical-downsize">
            <div class="orders-block" v-if="!is_orders_closed">
                <orders :room="room" :can-control="can_manipulate_room"
                        @closeOrders="manipulateOrdersVisibility"
                        @changeCurrentVideo="changeCurrentVideo"></orders>
            </div>
        </transition>
    </div>
    <div v-else>
        <o-loading overlayClass="is-transparent" :full-page="true" :active="!is_loaded" :can-cancel="false"></o-loading>
    </div>
</template>

<script>
import { API_GET_ROOM_DATA_BY_LINK_URL } from '@/api/rooms'
import errorsHelper from '@/mixins/errors.js'
import { mapState } from 'vuex'
import Player from '@/components/room/Player'
import Chat from '@/components/room/chat/Index'
import Orders from '@/components/room/orders/Index'
import broadcastConnections from '@/mixins/broadcastConnections'
import RoomSettingsManipulatingBlock from '@/components/room/SettingsManipulatingBlock'
import RoomSettingsModal from '@/components/modals/RoomSettingsModal'
import RoomMembersModal from '@/components/modals/RoomMembersModal'
import apiRequest from '@/helpers/apiRequest'

export default {
    name: 'Index',
    components: { RoomSettingsManipulatingBlock, Orders, Player, Chat },
    data() {
        return {
            is_loaded: false,
            room: {},
            users: [],
            can_manipulate_room: false,
            is_chat_below: false,
            is_chat_closed: false,
            is_orders_closed: false,
            host_id: 0,
            videoId: ''
        }
    },
    async beforeCreate() {
        try {
            await apiRequest(API_GET_ROOM_DATA_BY_LINK_URL, { roomLink: this.$route.params.link })
                .then((response) => {
                    this.room = response.data
                })
        } catch (error) {
            errorsHelper.methods.openResponseNotification(error)

            if (error.response.status === 404) {
                return this.$router.push('/404')
            }
        }

        if (this.current_room?.id !== this.room.id && this.created_room?.id !== this.room.id) {
            errorsHelper.methods.openNotification('You are not in this room')

            return this.$router.push({ name: 'RoomEntrance', params: { id: this.room.id } })
        }

        broadcastConnections.methods.connectToRoom(this.room.id)
            .here((users) => {
                this.users = users

                this.updateHost()
            })
            .joining((user) => {
                this.users.push(user)
            })
            .leaving((user) => {
                this.deleteMember(user.id)

                if (!this.room.can_everyone_control && user.id === this.room.owner.id) {
                    this.player.pauseVideo()
                } else {
                    this.updateHost()
                }
            })
            .listen('RoomUpdate', (response) => {
                this.$store.dispatch('rooms/changeCachedData', response.room)
                this.room = response.room
                this.updateCanManipulateRoom()
            })
            .listen('RoomMemberKick', (response) => {
                if (response.user.id === this.user.id) {
                    this.$store.dispatch('rooms/clearCachedData', { id: this.room.id })
                    errorsHelper.methods.openNotification('You were kicked from this room')
                    this.$router.push({ name: 'Rooms' })
                }

                this.deleteMember(response.user.id)
            })

        this.updateCanManipulateRoom()
        this.is_loaded = true
    },
    methods: {
        updateCanManipulateRoom() {
            this.can_manipulate_room = !!this.room.can_everyone_control || this.room.owner.id === this.user.id
        },
        deleteMember(memberId) {
            const leavedUserIndex = this.users.findIndex(object => object.id === memberId)
            if (leavedUserIndex !== -1) { this.users.splice(leavedUserIndex, 1) }
        },
        manipulateChatVisibility() {
            this.is_chat_closed = !this.is_chat_closed
        },
        manipulateOrdersVisibility() {
            this.is_orders_closed = !this.is_orders_closed
        },
        openSettingsModal() {
            this.$oruga.modal.open({
                component: RoomSettingsModal,
                props: {
                    room: this.room
                },
                trapFocus: true
            })
        },
        openMembersModal() {
            this.$oruga.modal.open({
                component: RoomMembersModal,
                props: {
                    currentMembers: this.users,
                    canControl: this.room.owner.id === this.user.id,
                    roomId: this.room.id,
                    host: this.host_id
                },
                trapFocus: true
            })
        },
        updateHost() {
            if (!this.room.can_everyone_control) {
                this.host_id = this.room.owner.id
                return
            }

            this.host_id = this.users.map(user => user.id).includes(this.room.owner.id) ? this.room.owner.id : this.users[0].id
        },
        changeCurrentVideo(video) {
            this.videoId = video?.video_url || ''
        }
    },
    computed: {
        ...mapState('auth', ['user']),
        ...mapState('rooms', ['current_room', 'created_room']),
        ...mapState('player', ['player'])
    }
}
</script>

<style lang="scss" scoped>
.chat {
    margin-bottom: 0 !important;
}

.activity-block {
    height: 70%;
}

.orders-block {
    height: 30%;
}

.fullscreen {
    transition: height 250ms;
    height: 100%;

    & .chat {
        margin-bottom: 0 !important;
    }
}

.chat-below {
    & .chat {
        margin-top: 20px;
        margin-left: 0;
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: calc(50% - 20px);
    }

    flex-direction: column;
}

@media (max-width: 600px) {
    .activity-block {
        flex-direction: column;
    }
    .chat {
        margin-top: 20px;
        margin-left: 0;
        max-width: 100%;
        width: 100%;
        height: calc(50% - 20px);
    }
}
</style>

<template>
    <div class="h-100">
        <div class="activity-block is-flex is-relative"
             :class="is_queue_closed ? 'fullscreen h-100 chat-below': ''">
            <player class="player"></player>
            <chat :room="current_room" v-if="!is_chat_closed" @close-chat="manipulateChatVisibility" class="chat"></chat>
            <visibility-manipulating-block v-if="is_chat_closed || is_queue_closed"
                                           @open-chat="manipulateChatVisibility"
                                           @open-queue="manipulateQueueVisibility"
                                           :is_chat_closed="is_chat_closed"
                                           :is_queue_closed="is_queue_closed"></visibility-manipulating-block>
        </div>
        <div class="queue-block" v-if="!is_queue_closed">
            <queue @closeQueue="manipulateQueueVisibility"></queue>
        </div>
    </div>
</template>

<script>
import {API_GET_ROOM_DATA_BY_LINK_URL} from "@/api/rooms";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import errorsHelper from "@/mixins/errors.js";
import {mapState} from "vuex";
import Player from "@/components/room/Player";
import Chat from "@/components/room/Chat/Index";
import Queue from "@/components/room/Queue/Index";
import VisibilityManipulatingBlock from "@/components/room/VisibilityManipulatingBlock";
import broadcastConnections from "@/mixins/broadcastConnections";

export default {
    name: "Index",
    components: {VisibilityManipulatingBlock, Queue, Player, Chat},
    data() {
        return {
            room: {
                'id': 0,
            },
            users: [],
            is_chat_closed: false,
            is_queue_closed: false,
        }
    },
    async mounted() {
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

            this.$router.push({'name': 'RoomEntrance', 'params': {'id': this.room.id}});
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
    },
    methods: {
        manipulateChatVisibility() {
            this.is_chat_closed = !this.is_chat_closed
        },
        manipulateQueueVisibility() {
            this.is_queue_closed = !this.is_queue_closed
        }
    },
    computed: {
        ...mapState('rooms', ['current_room']),
    }
}
</script>

<style lang="scss" scoped>
.activity-block {
    height: 70%;
}

.queue-block {
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

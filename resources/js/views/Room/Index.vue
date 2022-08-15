<template>
    <div class="room-content">
        <div class="activity-block is-flex">
            <player class="player"></player>
            <chat class="chat"></chat>
        </div>
        <div class="queue-block">
            <queue></queue>
        </div>
    </div>
</template>

<script>
import {API_GET_ROOM_DATA_BY_LINK_URL} from "@/api/rooms";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import errorsHelper from "@/mixins/errors.js";
import {mapState} from "vuex";
import Player from "@/components/room/Player";
import Chat from "@/components/room/Chat";
import Queue from "@/components/room/Queue";

export default {
    name: "Index",
    components: {Queue, Player, Chat},
    data() {
        return {
            room: {
                'id': 0,
            },
            users: [],
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

        Echo.join(`room.${this.room.id}`)
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
    computed: {
        ...mapState('rooms', ['current_room']),
    }
}
</script>

<style lang="scss" scoped>
    .room-content {
        height: 100%;
    }
    .activity-block {
        height: 70%;
    }
    .queue-block {
        height: 30%;
    }

    @media (max-width: 600px) {
        .activity-block {
            flex-direction: column;
        }
        .chat {
            margin-top: 20px;
        }
        .chat, .player {
            width: 100%;
            height: calc(50% - 20px);
        }
    }
</style>

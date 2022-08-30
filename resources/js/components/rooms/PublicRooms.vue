<template>
    <divider>All public rooms</divider>

    <div v-if="!pending" class="is-flex is-flex-direction-column">
        <room-row v-for="room in rooms"
                  :pending="roomToJoin === room.id"
                  @open-room="openRoom"
                  :room="room"
                  :is-owned="this.created_room?.id === room.id"
                  :is-current="[this.current_room?.id, this.created_room?.id].includes(room.id)"></room-row>

        <o-pagination
            :total="this.pagination.total"
            :per-page="this.pagination.per_page"
            :current="this.pagination.current_page"
            :range-before="3"
            :range-after="2"
            order="centered"
            @update:current="usePending(updatePublicRooms, 'pending', $event)">
        </o-pagination>
    </div>

    <div class="is-relative loading-block" v-else>
        <o-loading overlayClass="is-transparent" :full-page="false" :active="pending" :can-cancel="false"></o-loading>
    </div>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";
import RoomRow from "@/components/rooms/RoomRow";
import Divider from "@/components/Divider";
import {API_ALL_ROOMS_URL} from "@/api/rooms";
import usePending from "@/mixins/usePending";
import {mapState} from "vuex";
import errorsHelper from "@/mixins/errors";

export default {
    name: "PublicRooms",
    components: {SubmitButton, RoomRow, Divider},
    emits: ['updatePaginationPage'],
    mixins: [usePending],
    data() {
        return {
            rooms: [],
            pagination: {},
            pending: true,
            roomToJoin: 0,
        };
    },
    methods: {
        updatePublicRooms(page = 1, count = 15) {
            this.rooms = [];
            this.pagination = [];

            return axios.get(API_ALL_ROOMS_URL, {params: {'page': page, 'rooms_count': count}}).then((response) => {
                history.pushState({}, null, `${this.$route.path}?page=${page}`);
                this.rooms = response.data.data;
                this.pagination = response.data.pagination;

                if (this.pagination.count === 0) {
                    this.updatePublicRooms(this.pagination.total_pages);
                }
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async openRoom(room) {
            if (this.current_room?.id === room.id) {
                return this.$store.dispatch('rooms/open', room.link);
            }

            if (this.current_room?.id) {
                return errorsHelper.methods.openNotification('You are already in room');
            }

            if (this.roomToJoin) {
                return errorsHelper.methods.openNotification('You are already try to connect to another room');
            }

            this.roomToJoin = room.id;

            try {
                let roomData = await this.$store.dispatch('rooms/getData', room.id);
                if (roomData.is_closed) {
                    await this.$router.push({name: 'RoomEntrance', params: {'id': room.id}});
                } else {
                    await this.$store.dispatch('rooms/join', {'id': room.id, 'link': room.link});
                }
            } catch (errors) {
                errorsHelper.methods.openResponseNotification(errors);
            }

            this.roomToJoin = 0;
        }
    },
    mounted() {
        this.updatePublicRooms(this.$route.query.page).then(() => {
            this.pending = false;
        });
    },
    computed: {
        ...mapState('auth', ['user']),
        ...mapState('rooms', ['created_room', 'current_room']),
    }
}
</script>

<style>
.loading-block {
    height: 100px;
}
</style>

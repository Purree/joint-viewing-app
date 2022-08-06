<template>
    <divider>All public rooms</divider>

    <div v-if="!pending" class="is-flex is-flex-direction-column">
        <room-column v-for="room in rooms"
                     :name="room.name"
                     :is-locked="room.is_closed"
                     :link="room.link"
                     :is-owned="this.user.created_room.id === room.id"
                     :is-current="[this.user.current_room.id, this.user.created_room.id].includes(room.id)"></room-column>

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
import RoomColumn from "@/components/rooms/RoomColumn";
import Divider from "@/components/Divider";
import {API_ALL_ROOMS_URL} from "@/api/rooms";
import usePending from "@/mixins/usePending";
import {mapState} from "vuex";

export default {
    name: "PublicRooms",
    components: {SubmitButton, RoomColumn, Divider},
    emits: ['updatePaginationPage'],
    mixins: [usePending],
    data() {
        return {
            rooms: [],
            pagination: {},
            pending: true,
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
        }
    },
    mounted() {
        this.updatePublicRooms(this.$route.query.page).then(() => {
            this.pending = false;
        });
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style>
.loading-block {
    height: 100px;
}
</style>

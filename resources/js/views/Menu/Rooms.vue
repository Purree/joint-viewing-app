<template>

    <current-room :create-new-room-pending="createNewRoomPending"></current-room>

    <public-rooms :is-public-rooms-loaded="isPublicRoomsLoaded" :public-rooms="publicRooms"></public-rooms>

</template>

<script>
import RoomColumn from "@/components/rooms/RoomColumn.vue";
import {mapState} from "vuex";
import SubmitButton from "@/components/SubmitButton";
import usePending from "@/mixins/usePending";
import Divider from "@/components/Divider";
import CurrentRoom from "@/components/rooms/CurrentRoom";
import PublicRooms from "@/components/rooms/PublicRooms";
import {API_ALL_ROOMS_URL} from "@/api/rooms";

export default {
    name: "Rooms",
    components: {PublicRooms, CurrentRoom, SubmitButton, RoomColumn, Divider},
    mixins: [usePending],
    data() {
        return {
            createNewRoomPending: false,
            isPublicRoomsLoaded: false,
            publicRooms: [],
        };
    },
    methods: {
        updatePublicRooms() {
            this.publicRooms = [];

            return axios.get(API_ALL_ROOMS_URL).then((response) => {
                this.publicRooms = response.data;
            }).catch((error) => {
                console.log(error.response);
            });
        }
    },
    mounted() {
        this.updatePublicRooms().then(() => {
            this.isPublicRoomsLoaded = true;
        });
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style scoped>

</style>

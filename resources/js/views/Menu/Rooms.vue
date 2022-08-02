<template>

    <current-room :create-new-room-pending="createNewRoomPending"></current-room>

    <public-rooms></public-rooms>

</template>

<script>
import RoomColumn from "@/components/rooms/RoomColumn.vue";
import {mapState} from "vuex";
import SubmitButton from "@/components/SubmitButton";
import usePending from "@/mixins/usePending";
import Divider from "@/components/Divider";
import CurrentRoom from "@/components/rooms/CurrentRoom";
import PublicRooms from "@/components/rooms/PublicRooms";

export default {
    name: "Rooms",
    components: {PublicRooms, CurrentRoom, SubmitButton, RoomColumn, Divider},
    mixins: [usePending],
    data() {
        return {
            createNewRoomPending: false,
        };
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style scoped>

</style>

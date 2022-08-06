<template>
    <divider>Current room</divider>
    <div v-if="this.user.current_room !== null || this.user.created_room !== null">
        <room-column :name="this.user.current_room.name || 'Empty name'"
                     :is-locked="this.user.current_room.is_closed"
                     :link="this.user.current_room.link"
                     :is-owned="this.user.created_room.id === this.user.current_room.id"
                     :is-current="true"></room-column>

        <room-column v-if="this.user.current_room.id !== this.user.created_room.id"
                     :name="this.user.created_room.name || 'Empty name'"
                     :is-locked="this.user.created_room.is_closed"
                     :link="this.user.created_room.link"
                     :is-owned="true"></room-column>
    </div>
    <div v-else>
        <submit-button class="is-fullwidth"
                       :is-loading="createNewRoomPending"
                       :pending="createNewRoomPending"
                       text="Create new room"
                       @click="usePending"></submit-button>
    </div>
</template>

<script>
import {mapState} from "vuex";
import SubmitButton from "@/components/SubmitButton";
import RoomColumn from "@/components/rooms/RoomColumn";
import Divider from "@/components/Divider";

export default {
    name: "CurrentRoom",
    components: {SubmitButton, RoomColumn, Divider},
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

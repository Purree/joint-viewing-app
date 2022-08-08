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
        <room-manipulate-block send-request-button-text="Create room"
                               :send-request-pending="createRoomPending"
                               v-if="wantToCreateRoom"
                               :errors="roomCreateErrors"
                               :is-creating="true"></room-manipulate-block>

        <submit-button v-else
                       class="is-fullwidth"
                       text="Create new room"
                       @click="wantToCreateRoom = true"></submit-button>
    </div>
</template>

<script>
import {mapState} from "vuex";
import SubmitButton from "@/components/SubmitButton";
import RoomColumn from "@/components/rooms/RoomColumn";
import Divider from "@/components/Divider";
import RoomManipulateBlock from "@/components/rooms/RoomManipulateBlock";

export default {
    name: "CurrentRoom",
    components: {RoomManipulateBlock, SubmitButton, RoomColumn, Divider},
    data() {
        return {
            createRoomPending: false,
            wantToCreateRoom: false,
            roomCreateErrors: {},
        };
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style scoped>

</style>

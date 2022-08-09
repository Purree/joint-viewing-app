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
                               :is-creating="true"
                               @update-room="createRoom"></room-manipulate-block>

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
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";
import {API_CREATE_ROOM_URL} from "@/api/rooms";

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
    methods: {
        createRoom(form) {
            if (this.createRoomPending) {
                return;
            }
            this.createRoomPending = true;

            if (!form.is_closed) {
                delete form.password;
            }

            return axios.post(API_CREATE_ROOM_URL, form)
                .then(response => {
                    this.user.created_room = response.data;
                    this.user.current_room = response.data;
                    this.wantToCreateRoom = false;
                })
                .catch(errors => {
                    this.roomCreateErrors = getErrorsFromResponse(errors);
                }).then(() => {
                    this.createRoomPending = false;
                });
        },
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style scoped>

</style>

<template>
    <divider>Current room</divider>
    <div v-if="this.current_room !== null || this.created_room !== null">
        <room-column :room="this.current_room"
                     :is-owned="this.created_room.id === this.current_room.id"
                     :is-current="true"></room-column>

        <room-column v-if="this.current_room.id !== this.created_room.id"
                     :room="this.created_room"
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
                    this.$store.commit('rooms/setCreatedRoom', response.data);
                    this.$store.commit('rooms/setCurrentRoom', response.data);
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
        ...mapState('rooms', ['current_room', 'created_room']),
    }
}
</script>

<style scoped>

</style>

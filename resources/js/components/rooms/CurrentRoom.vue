<template>
    <divider>Current room</divider>
    <div v-if="this.current_room !== null || this.created_room !== null">
        <room-row @open-room="openRoom"
                  v-if="this.current_room?.id"
                  :room="this.current_room"
                  :is-owned="this.created_room?.id === this.current_room?.id"
                  :is-current="true"></room-row>

        <room-row @open-room="openRoom"
                  v-if="this.created_room?.id && this.current_room?.id !== this.created_room.id"
                  :room="this.created_room"
                  :is-owned="true"></room-row>
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
import { mapState } from 'vuex'
import SubmitButton from '@/components/SubmitButton'
import RoomRow from '@/components/rooms/RoomRow'
import Divider from '@/components/Divider'
import RoomManipulateBlock from '@/components/rooms/RoomManipulateBlock'
import errorsHelper from '@/mixins/errors'
import { API_CREATE_ROOM_URL } from '@/api/rooms'
import apiRequest from '@/helpers/apiRequest'

export default {
    name: 'CurrentRoom',
    components: { RoomManipulateBlock, SubmitButton, RoomRow, Divider },
    data() {
        return {
            createRoomPending: false,
            wantToCreateRoom: false,
            roomCreateErrors: {}
        }
    },
    methods: {
        createRoom(form) {
            if (this.createRoomPending) {
                return
            }
            this.createRoomPending = true

            if (!form.is_closed) {
                delete form.password
            }

            return apiRequest(API_CREATE_ROOM_URL, {}, form)
                .then(response => {
                    this.$store.commit('rooms/setCreatedRoom', response.data)
                    this.$store.commit('rooms/setCurrentRoom', response.data)
                    this.wantToCreateRoom = false
                })
                .catch(errors => {
                    this.roomCreateErrors = errorsHelper.methods.getFromResponse(errors)
                }).then(() => {
                    this.createRoomPending = false
                })
        },
        openRoom(room) {
            this.$store.dispatch('rooms/open', room.link)
        }
    },
    computed: {
        ...mapState('auth', ['user']),
        ...mapState('rooms', ['current_room', 'created_room'])
    }
}
</script>

<style scoped>

</style>

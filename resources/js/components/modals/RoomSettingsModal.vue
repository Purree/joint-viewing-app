<template>
    <div class="box box-bordered">
        <SuccessfulArticle v-if="isSuccess" text="Successfully update room"/>

        <room-manipulate-block :is-creating="false"
                               :room-data="room"
                               send-request-button-text="Update room"
                               :errors="errors"
                               :send-request-pending="pending"
                               @update-room="updateRoom"></room-manipulate-block>
    </div>
</template>

<script>
import RoomManipulateBlock from '@/components/rooms/RoomManipulateBlock'
import errorsHelper from '@/mixins/errors'
import SuccessfulArticle from '@/components/SuccessfulArticle'

export default {
    name: 'RoomSettingsModal',
    components: { RoomManipulateBlock, SuccessfulArticle },
    props: {
        room: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            errors: {},
            pending: false,
            isSuccess: false
        }
    },
    methods: {
        async updateRoom(newRoomData) {
            if (this.pending) {
                return
            }
            this.pending = true
            this.isSuccess = false
            this.errors = {}

            if (!newRoomData.password || !newRoomData.is_closed) {
                delete newRoomData.password
            }
            newRoomData.id = this.room.id

            try {
                await this.$store.dispatch('rooms/update', newRoomData)
                this.isSuccess = true
            } catch (errors) {
                this.errors = errorsHelper.methods.getFromResponse(errors)
            } finally {
                this.pending = false
            }
        }
    }
}
</script>

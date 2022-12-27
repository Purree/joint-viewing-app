<template>

    <current-room></current-room>

    <public-rooms></public-rooms>

</template>

<script>
import RoomRow from '@/components/rooms/RoomRow.vue'
import { mapState } from 'vuex'
import SubmitButton from '@/components/SubmitButton'
import Divider from '@/components/Divider'
import CurrentRoom from '@/components/rooms/CurrentRoom'
import PublicRooms from '@/components/rooms/PublicRooms'

export default {
    name: 'Rooms',
    components: { PublicRooms, CurrentRoom, SubmitButton, RoomRow, Divider },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>

</style>

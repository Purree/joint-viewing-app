<template>

    <current-room></current-room>

    <public-rooms></public-rooms>

</template>

<script>
import { mapState } from 'vuex'
import CurrentRoom from '@/components/rooms/CurrentRoom'
import PublicRooms from '@/components/rooms/PublicRooms'

export default {
    name: 'Rooms',
    components: { PublicRooms, CurrentRoom },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

export default {
    methods: {
        connectToRoom(roomId) {
            return Echo.join(`room.${roomId}`)
        }
    }
}

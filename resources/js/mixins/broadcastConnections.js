export default {
    methods: {
        connectToRoom(roomId) {
            return window.Echo.join(`room.${roomId}`)
        }
    }
}

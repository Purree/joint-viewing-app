export default {
    state: {
        current_room: {},
        created_room: {}
    },
    mutations: {
        setCurrentRoom(state, room) {
            state.current_room = room
        },
        setCreatedRoom(state, room) {
            state.created_room = room
        },
    },
    namespaced: true
}

export default {
    state: {
        player: false
    },
    mutations: {
        setPlayer(state, player) {
            state.player = player
        }
    },
    namespaced: true
}

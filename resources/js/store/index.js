import {createStore} from "vuex";

const store = createStore({
    state: {
        user: null
    },
    getters: {
        getAuthUser(state) {
            return state.user;
        }

    },
    mutations: {
        setAuthUser(state, user) {
            state.user = user;
        }
    },
    actions: {},
    modules: {}
})

export default store;

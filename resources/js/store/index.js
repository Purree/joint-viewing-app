import {createStore} from "vuex";

const store = createStore({
    state: {
        userToken: null
    },
    getters: {
        getUserToken(state) {
            return state.userToken;
        }

    },
    mutations: {
        setUserToken(state, token) {
            state.userToken = token;
        }
    },
    actions: {},
    modules: {}
})

export default store;

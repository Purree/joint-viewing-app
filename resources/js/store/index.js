import {createStore} from "vuex";

const store = createStore({
    state: {
        userToken: null
    },
    getters: {
        getUserToken(state) {
            return state.userToken;
        },
        isLoggedIn(state) {
            return !!state.userToken
        }
    },
    mutations: {
        setUserToken(state, token) {
            localStorage.setItem('auth-token', token)
            state.userToken = token;
        }
    },
    actions: {},
    modules: {}
})

export default store;

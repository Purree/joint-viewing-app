import {createStore} from "vuex";

const store = createStore({
    state: {
        userToken: null,
        user: {}
    },
    getters: {
        getUserToken(state) {
            return state.userToken;
        },
        getUser(state) {
            return state.user;
        },
        isLoggedIn(state) {
            return !!state.userToken && state.userToken !== 'null';
        }
    },
    mutations: {
        setUserToken(state, token) {
            if (token !== null) {
                localStorage.setItem('auth-token', token)
            } else {
                localStorage.removeItem('auth-token')
            }

            state.userToken = token;
        },
        setUser(state, user) {
            state.user = user
        }
    },
    actions: {},
    modules: {}
})

export default store;

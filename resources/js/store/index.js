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
            return !!state.userToken && state.userToken !== 'null'
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
        }
    },
    actions: {},
    modules: {}
})

export default store;

export default {
    state: {
        userToken: null,
        user: {}
    },
    getters: {
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

            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            state.userToken = token;
        },
        setUser(state, user) {
            state.user = user
        }
    },
    namespaced: true
}

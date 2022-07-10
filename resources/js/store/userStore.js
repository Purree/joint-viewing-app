import axios from "axios";
import {API_LOGOUT_URL} from "@/api/auth";
import router from "@/routes";

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
    actions: {
        logout({ commit }) {
            axios.post(API_LOGOUT_URL)
                .catch((error) => {
                    console.log(error.response.data)
                }).then((response) => {
                    commit('setUserToken', null);

                    router.push({ name: 'Login' });
                })
        }
    },
    namespaced: true
}

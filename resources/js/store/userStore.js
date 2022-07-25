import axios from "axios";
import {API_LOGOUT_URL} from "@/api/auth.js";
import router from "@/routes/index.js";

export default {
    state: {
        isLoggedIn: false,
        user: {}
    },
    mutations: {
        setUser(state, user) {
            state.user = user
        },
        setIsLoggedIn(state, isLoggedIn = !state.isLoggedIn) {
            isLoggedIn = typeof isLoggedIn === 'string' ? isLoggedIn === 'true' : !!isLoggedIn

            localStorage.setItem('isLoggedIn', `${isLoggedIn}`)
            state.isLoggedIn = isLoggedIn
        }
    },
    getters: {
        isLoggedIn(state) {
            return state.isLoggedIn
        }
    },
    actions: {
        logout({ commit }) {
            return axios.post(API_LOGOUT_URL)
                .catch((error) => {
                    console.log(error.response.data)
                }).then(() => {
                    commit('setIsLoggedIn', false);

                    router.push({ name: 'Login' });
                })
        }
    },
    namespaced: true
}

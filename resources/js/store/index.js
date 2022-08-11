import {createStore} from "vuex";
import user from "@/store/user.js";
import rooms from "@/store/rooms.js";

const store = createStore({
    state: {
        theme: 'light'
    },
    getters: {
        getTheme: (state) => {
            return state.theme
        }
    },
    mutations: {
        setTheme: (state, theme) => {
            localStorage.setItem('theme', theme);
            state.theme = theme;
            document.documentElement.setAttribute('data-theme', theme);
        }
    },
    actions: {},
    modules: {auth: user, rooms: rooms},
})

export default store;

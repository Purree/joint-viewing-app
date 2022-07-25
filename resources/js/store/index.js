import {createStore} from "vuex";
import userStore from "@/store/userStore.js";

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
    modules: {auth: userStore}
})

export default store;

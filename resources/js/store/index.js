import {createStore} from "vuex";

const store = createStore({
    state: {
        posts: [],
    },
    getters: {
        allPosts(state) {
            return state.posts
        },
    },
    mutations: {},
    actions: {},
    modules: {}
})

export default store;

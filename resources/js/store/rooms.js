import replaceDataInUri from "@/mixins/replaceDataInUri";
import {API_GET_ROOM_DATA_URL, API_JOIN_ROOM_URL} from "@/api/rooms";
import router from "@/routes/index.js";

export default {
    state: {
        current_room: {},
        created_room: {}
    },
    mutations: {
        setCurrentRoom(state, room) {
            state.current_room = room
        },
        setCreatedRoom(state, room) {
            state.created_room = room
        },
    },
    actions: {
        getData({_commit}, id) {
            return axios.get(replaceDataInUri(API_GET_ROOM_DATA_URL, {'roomId': id}))
                .then(response => {
                    return response.data;
                });
        },
        join({commit, dispatch}, payload) {
            return axios.post(replaceDataInUri(API_JOIN_ROOM_URL, {'roomId': payload['id']}), {
                ...payload['password'] ? {password: payload['password']}: {}
            }).then((response) => {
                commit('setCurrentRoom', response.data);

                if (payload['link']) {
                    dispatch('open', payload['link']);
                }
            })
        },
        open({_commit}, link) {
            router.push({ name: 'Room', params: { 'link': link } });
        }
    },
    namespaced: true
}

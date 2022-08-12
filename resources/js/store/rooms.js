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
        getRoomData({_commit}, roomId) {
            return axios.get(replaceDataInUri(API_GET_ROOM_DATA_URL, {'roomId': roomId}))
                .then(response => {
                    return response.data;
                });
        },
        joinRoom({commit}, roomId, roomLink = null, password = null) {
            return axios.post(replaceDataInUri(API_JOIN_ROOM_URL, {'roomId': roomId}), {
                password: password
            }).then((response) => {
                commit('rooms/setCurrentRoom', response.data());

                if (roomLink) {
                    router.push({ name: 'Room', params: { 'id': roomLink } });
                }
            })
        }
    },
    namespaced: true
}

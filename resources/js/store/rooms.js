import { API_GET_ROOM_DATA_URL, API_JOIN_ROOM_URL, API_LEAVE_ROOM_URL, API_UPDATE_ROOM_URL } from '@/api/rooms'
import router from '@/routes/index.js'
import apiRequest from '@/helpers/apiRequest'

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
        }
    },
    actions: {
        getData({ _commit }, id) {
            return apiRequest(API_GET_ROOM_DATA_URL, { roomId: id })
                .then(response => {
                    return response.data
                })
        },
        changeCachedData({ commit, state }, payload) {
            if (payload.id === state.current_room?.id) {
                commit('setCurrentRoom', payload)
            }

            if (payload.id === state.created_room?.id) {
                commit('setCreatedRoom', payload)
            }
        },
        clearCachedData({ commit, state }, payload) {
            if (payload.id === state.current_room?.id) {
                commit('setCurrentRoom', null)
            }

            if (payload.id === state.created_room?.id) {
                commit('setCreatedRoom', null)
            }
        },
        join({ commit, dispatch }, payload) {
            return apiRequest(API_JOIN_ROOM_URL, { roomId: payload.id }, {
                ...payload.password ? { password: payload.password } : {}
            }).then((response) => {
                commit('setCurrentRoom', response.data)

                if (payload.link) {
                    dispatch('open', payload.link)
                }
            })
        },
        leave({ dispatch }, payload) {
            return apiRequest(API_LEAVE_ROOM_URL, { roomId: payload.id })
                .then(() => {
                    dispatch('clearCachedData', payload)

                    if (payload.redirectToRooms) {
                        router.push({ name: 'Rooms' })
                    }
                })
        },
        update({ dispatch }, payload) {
            return apiRequest(API_UPDATE_ROOM_URL, { roomId: payload.id }, payload)
                .then((response) => {
                    dispatch('changeCachedData', response.data)
                })
        },
        open({ _commit }, link) {
            router.push({ name: 'Room', params: { link } })
        }
    },
    namespaced: true
}

<template>
    <divider>All public rooms</divider>

    <div v-if="!pending" class="is-flex is-flex-direction-column">
        <div v-if="this.rooms.length > 0">
            <room-row :key="room.id"
                      v-for="room in rooms"
                      :pending="roomToJoin === room.id"
                      @delete-room="removeRoom"
                      @open-room="openRoom"
                      :room="room"
                      :is-owned="this.created_room?.id === room.id"
                      :is-current="this.current_room?.id === room.id"></room-row>

            <o-pagination
                :total="this.pagination.total"
                :per-page="this.pagination.per_page"
                :current="this.pagination.current_page"
                :range-before="3"
                :range-after="2"
                order="centered"
                @update:current="usePending(getPublicRooms, 'pending', $event)">
            </o-pagination>
        </div>
        <div v-else>
            <div class="has-text-centered">
                <p class="is-size-5">No public rooms</p>
            </div>
        </div>
    </div>

    <div class="is-relative loading-block" v-else>
        <o-loading overlayClass="is-transparent" :full-page="false" :active="pending" :can-cancel="false"></o-loading>
    </div>
</template>

<script>
import RoomRow from '@/components/rooms/RoomRow'
import Divider from '@/components/Divider'
import { API_ALL_ROOMS_URL } from '@/api/rooms'
import usePending from '@/mixins/usePending'
import { mapState } from 'vuex'
import errorsHelper from '@/mixins/errors'
import apiRequest from '@/helpers/apiRequest'

export default {
    name: 'PublicRooms',
    components: {
        RoomRow,
        Divider
    },
    emits: ['updatePaginationPage'],
    mixins: [usePending],
    data() {
        return {
            rooms: [],
            pagination: {},
            pending: true,
            roomToJoin: 0
        }
    },
    methods: {
        getPublicRooms(page = 1, count = 15) {
            this.rooms = []
            this.pagination = []

            return apiRequest(API_ALL_ROOMS_URL, {}, {
                params: {
                    page,
                    rooms_count: count
                }
            }).then((response) => {
                history.pushState({}, null, `${this.$route.path}?page=${page}`)
                this.rooms = response.data.data
                this.pagination = response.data.pagination

                if (this.pagination.count === 0 && this.pagination.current_page > 1) {
                    this.getPublicRooms(this.pagination.total_pages)
                }
            }).catch((error) => {
                console.log(error.response)
            })
        },
        async openRoom(room) {
            if (this.current_room?.id === room.id || this.created_room?.id === room.id) {
                return this.$store.dispatch('rooms/open', room.link)
            }

            if (this.current_room?.id || this.created_room?.id) {
                return errorsHelper.methods.openNotification('You are already in room')
            }

            if (this.roomToJoin) {
                return errorsHelper.methods.openNotification('You are already try to connect to another room')
            }

            this.roomToJoin = room.id

            try {
                const roomData = await this.$store.dispatch('rooms/getData', room.id)
                if (roomData.is_closed) {
                    await this.$router.push({
                        name: 'RoomEntrance',
                        params: { id: room.id }
                    })
                } else {
                    await this.$store.dispatch('rooms/join', {
                        id: room.id,
                        link: room.link
                    })
                }
            } catch (errors) {
                errorsHelper.methods.openResponseNotification(errors)
            }

            this.roomToJoin = 0
        },
        removeRoom(id) {
            this.rooms = this.rooms.filter((room) => room.id !== id)
        }
    },
    mounted() {
        this.getPublicRooms(this.$route.query.page).then(() => {
            this.pending = false
        })
    },
    computed: {
        ...mapState('auth', ['user']),
        ...mapState('rooms', ['created_room', 'current_room'])
    }
}
</script>

<style>
.loading-block {
    height: 100px;
}
</style>

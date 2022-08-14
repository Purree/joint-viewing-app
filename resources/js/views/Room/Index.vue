<template>

</template>

<script>
import {API_GET_ROOM_DATA_BY_LINK_URL} from "@/api/rooms";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import errorsHelper from "@/mixins/errors.js";
import {mapState} from "vuex";

export default {
    name: "Index",
    data() {
        return {
            room: {
                'id': 0,
            },
            users: [],
        }
    },
    async mounted() {
        try {
            await axios.get(replaceDataInUri(API_GET_ROOM_DATA_BY_LINK_URL, {'roomLink': this.$route.params.link}))
                .then((response) => {
                    this.room = response.data;
                })
        } catch (error) {
            errorsHelper.methods.openResponseNotification(error)

            if (error.response.status === 404) {
                return this.$router.push('/404');
            }
        }

        if (this.current_room?.id !== this.room.id) {
            errorsHelper.methods.openNotification('You are not in this room');

            if (window.history.length > 2) {
                this.$router.back()
            } else {
                this.$router.push({'name': 'Rooms'})
            }
        }

        Echo.join(`room.${this.room.id}`).here((users) => {
            this.users = users;
        });
    },
    computed: {
        ...mapState('rooms', ['current_room']),
    }
}
</script>

<style scoped>

</style>

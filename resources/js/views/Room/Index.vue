<template>

</template>

<script>
import {API_GET_ROOM_DATA_BY_LINK_URL} from "@/api/rooms";
import replaceDataInUri from "@/mixins/replaceDataInUri";

export default {
    name: "Index",
    data() {
        return {
            room: {
                'id': 0,
            }
        }
    },
    async mounted() {
        await axios.get(replaceDataInUri(API_GET_ROOM_DATA_BY_LINK_URL, {'roomLink': this.$route.params.link}))
            .then((response) => {
                this.room = response.data;
            }).catch((error) => {
                console.log(error);
            });

        Echo.join(`room.${this.room.id}`);
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="divider">Current room</div>
    <div v-if="this.user.current_room !== null">
        <room-column name="Normal room name" :is-locked="true" link="testRoom"></room-column>
    </div>
    <div v-else>
        <submit-button class="is-fullwidth"
                       :is-loading="createNewRoomPending"
                       :pending="createNewRoomPending"
                       text="Create new room"
                       @click="usePending"></submit-button>
    </div>
    <div class="divider">All public rooms</div>
    <div class="columns is-flex-direction-column">
        <room-column name="Normal room name" :is-locked="true" link="testRoom"></room-column>
        <room-column name="Normal room name" :is-locked="false" link="testRoom"></room-column>
        <room-column name="Normal room name" :is-locked="true" link="testRoom"></room-column>
        <room-column name="Normal room name" :is-locked="false" link="testRoom"></room-column>
        <room-column name="Very long room name. Test room with long name without is locked parameter. ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss"
                     link="testRoom"></room-column>
        <room-column :is-locked="true" link="testRoom"></room-column>
        <room-column name="Very long room name. With is locked parameter. ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss"
                     :is-locked="true" link="testRoom"></room-column>
        <room-column link="testRoom"></room-column>
    </div>
</template>

<script>
import RoomColumn from "@/components/rooms/RoomColumn.vue";
import {mapState} from "vuex";
import SubmitButton from "@/components/SubmitButton";
import usePending from "@/mixins/usePending";

export default {
    name: "Rooms",
    components: {SubmitButton, RoomColumn},
    mixins: [usePending],
    data() {
        return {
            createNewRoomPending: false,
        };
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style scoped>

</style>

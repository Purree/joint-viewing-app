<template>
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

export default {
    name: "Rooms",
    components: {RoomColumn}
}
</script>

<style scoped>

</style>

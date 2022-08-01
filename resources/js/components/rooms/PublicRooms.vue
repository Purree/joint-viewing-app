<template>
    <divider>All public rooms</divider>

    <div v-if="isPublicRoomsLoaded" class="is-flex is-flex-direction-column">
        <room-column v-for="room in publicRooms"
                     :name="room.name"
                     :is-locked="room.is_closed"
                     :link="room.link"></room-column>
    </div>

    <div class="is-relative loading-block" v-else>
        <o-loading overlayClass="is-transparent" :full-page="false" :active="!isPublicRoomsLoaded" :can-cancel="false"></o-loading>
    </div>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";
import RoomColumn from "@/components/rooms/RoomColumn";
import Divider from "@/components/Divider";

export default {
    name: "PublicRooms",
    components: {SubmitButton, RoomColumn, Divider},
    props: {
        isPublicRoomsLoaded: {
            type: Boolean,
            default: false,
        },
        publicRooms: {
            type: Array,
            default: [],
        },
    },
}
</script>

<style>
    .loading-block {
        height: 100px;
    }
</style>

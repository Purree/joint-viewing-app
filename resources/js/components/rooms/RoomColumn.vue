<template>
    <div class="column box is-flex is-align-items-center is-hovered" @click="openRoom">
        <div class="mr-2">
            <o-icon pack="fas" :icon="isLocked ? 'lock' : 'unlock'" size="medium"> </o-icon>
        </div>
        <div class="room-text-information">
            <div>{{ name || 'Empty room name' }}</div>
            <div><router-link :to="{ name: 'Room', params: { 'id': link } }">{{ link }}</router-link></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RoomColumn",
    props: ['name', 'isLocked', 'link'],
    methods: {
        openRoom() {
            this.$router.push({ name: 'Room', params: { 'id': this.link } });
        }
    }
}
</script>

<style scoped>
    .room-text-information {
        width: 95%;
        overflow: hidden;
        white-space: nowrap;
    }
</style>

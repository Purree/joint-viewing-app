<template>
    <div class="column box is-flex is-align-items-center is-hovered" @click="$emit('openRoom', this.room)">
        <div class="mr-2">
            <o-icon pack="fas" :icon="this.room.is_closed ? 'lock' : 'unlock'" size="medium"></o-icon>
        </div>
        <div class="room-text-information">
            <div>{{ this.room.name || 'Empty room name' }}</div>
            <div>
                <router-link :to="{ name: 'Room', params: { 'link': this.room.link } }">{{ this.room.link }}</router-link>
            </div>
        </div>
        <div class="status_icon" v-if="isOwned">
            <o-icon pack="fas" :icon="'star'" size="medium"></o-icon>
        </div>
        <div class="status_icon" v-if="isCurrent">
            <o-icon pack="fas" :icon="'clock'" size="medium"></o-icon>
        </div>
    </div>
</template>

<script>
export default {
    name: "RoomColumn",
    props: {
        room: {
            type: Object,
            required: true,
            default: () => ({
                id: 0,
                name: '',
                link: '',
                isLocked: false,
            }),
        }, isOwned: {
            type: Boolean,
            default: false,
        }, isCurrent: {
            type: Boolean,
            default: false,
        },
    },
}
</script>

<style scoped>
.room-text-information {
    width: 95%;
    overflow: hidden;
    white-space: nowrap;
}

.status_icon {
    margin-left: 5px;
    border-radius: 100%;
    background-color: cadetblue;
}
</style>

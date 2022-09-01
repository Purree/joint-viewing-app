<template>
    <div class="column box is-flex is-align-items-center is-hovered"
         :class="{'is-disabled' : pending}"
         @click="$emit('openRoom', this.room)">
        <div class="mr-2">
            <o-icon pack="fas" :icon="this.room.is_closed ? 'lock' : 'unlock'" size="medium"></o-icon>
        </div>
        <div class="room-text-information is-overflow-hidden">
            <div>{{ this.room.name || 'Empty room name' }}</div>
            <div>
                <router-link to="">
                    {{ this.room.link }}
                </router-link>
            </div>
        </div>
        <div v-if="isOwned || isCurrent">
            <o-button variant="danger"
                      @click.stop="usePending(leaveRoom, 'leavePending')"
                      icon-right="arrow-right-from-bracket"
                      outlined
                      rounded
                      :disabled="leavePending"
                      :class="{'is-loading': leavePending}"></o-button>
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
import usePending from "@/mixins/usePending";

export default {
    name: "RoomRow",
    emits: ['openRoom', 'deleteRoom'],
    mixins: [usePending],
    data() {
        return {
            leavePending: false,
        }
    },
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
        }, pending: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        async leaveRoom() {
            return this.$store.dispatch('rooms/leave', {'id': this.room.id}).then(async () => {
                try {
                    let response = await this.$store.dispatch('rooms/getData', this.room.id)

                    if (response.data.is_private) {
                        this.$emit('deleteRoom', this.room.id);
                    }
                } catch (error) {
                    this.$emit('deleteRoom', this.room.id);
                }
            });
        }
    }
}
</script>

<style scoped>
.room-text-information {
    width: 95%;
    white-space: nowrap;
}

.status_icon {
    margin-left: 5px;
    border-radius: 100%;
    background-color: cadetblue;
}
</style>

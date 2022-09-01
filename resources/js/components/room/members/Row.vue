<template>
    <div class="box columns is-align-items-center is-justify-content-space-between">
        <user-avatar class="column is-1 mr-3" :avatar-path="member?.avatar"></user-avatar>
        <div class="column is-overflow-hidden">
            <div class="is-ellipsis">
                {{ member.name }}
            </div>
            <div :class="isOnline ? 'has-text-success' : 'has-text-danger'">
                This user is {{ isOnline ? 'online' : 'offline' }} now
            </div>
        </div>
        <div class="column is-1" v-if="canControl">
            <o-button variant="danger">Kick</o-button>
        </div>
    </div>
</template>

<script>
import UserAvatar from "@/components/UserAvatar";
export default {
    name: "RoomMembersRow",
    components: {UserAvatar},
    props: {
        member: {
            type: Object,
            required: true
        },
        isOnline: {
            type: Boolean,
            required: true
        },
        canControl: {
            type: Boolean,
            required: true
        },
    },
}
</script>

<style scoped lang="scss">
    .columns {
        &:not(:last-child) {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        &:not(:first-child) {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    }
</style>

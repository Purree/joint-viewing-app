<template>
    <div class="box is-flex is-align-items-center is-justify-content-space-between">
        <div class="is-flex is-overflow-hidden">
            <user-avatar class="user-avatar mr-3" :avatar-path="member?.avatar"></user-avatar>
            <div class="is-overflow-hidden">
                <div class="is-ellipsis">
                    {{ member.name }}
                </div>
                <div :class="isOnline ? 'has-text-success' : 'has-text-danger'">
                    This user is {{ isOnline ? 'online' : 'offline' }} now
                </div>
            </div>
        </div>
        <div v-if="canControl">
            <o-button :disabled="kickPending"
                      :class="{'is-loading': kickPending}"
                      variant="danger"
                      @click="$emit('kick', member.id)">Kick</o-button>
        </div>
    </div>
</template>

<script>
import UserAvatar from "@/components/UserAvatar";
export default {
    name: "RoomMembersRow",
    components: {UserAvatar},
    emits: ['kick'],
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
        kickPending: {
            type: Boolean,
            required: true
        }
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
    .user-avatar {
        flex-shrink: 0;
    }
</style>

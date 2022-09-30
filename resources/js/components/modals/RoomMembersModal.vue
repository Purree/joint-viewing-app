<template>
    <div class="box box-bordered members-modal">
        <div v-if="!modalPending">
            <o-button @click="usePending(updateMembers, 'updateMembersPending')"
                      variant="danger"
                      class="is-fullwidth refresh-button"
                      :disabled="updateMembersPending"
                      :class="{'is-loading': updateMembersPending}">Refresh</o-button>
            <transition-group name="slide-next">
                <room-members-row v-for="member in members"
                                  :can-control="canControl"
                                  :member="member"
                                  :kick-pending="contendersForKick.includes(member.id)"
                                  :is-online="currentMembers.some(onlineMember => onlineMember.id === member.id)"
                                  :is-host="member.id === host"
                                  @kick="kickUser"></room-members-row>
            </transition-group>
        </div>
        <div v-else>
            <o-loading :full-page="false" overlayClass="is-transparent" class="mb-5" :can-cancel="false" :active="modalPending"></o-loading>
        </div>
    </div>
</template>

<script>
import RoomMembersRow from "@/components/room/members/Row";
import replaceDataInUri from "@/helpers/replaceDataInUri";
import {API_GET_ALL_MEMBERS_URL, API_KICK_MEMBER_URL} from "@/api/rooms";
import errorsHelper from "@/mixins/errors.js";
import usePending from "@/mixins/usePending";
import apiRequest from "@/helpers/apiRequest";

export default {
    name: "RoomMembersModal",
    components: {RoomMembersRow},
    mixins: [usePending],
    props: {
        roomId: {
            type: Number,
            required: true
        },
        currentMembers: {
            type: Array,
            required: true
        },
        canControl: {
            type: Boolean,
            required: true
        },
        host: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            members: [],
            updateMembersPending: false,
            modalPending: true,
            contendersForKick: []
        }
    },
    methods: {
        updateMembers() {
            return apiRequest(API_GET_ALL_MEMBERS_URL, {'roomId': this.roomId})
                .then((response) => {
                    this.members = response.data;
                }).catch((errors) => {
                    errorsHelper.methods.openResponseNotification(errors);
                })
        },
        kickUser(userId) {
            if (this.contendersForKick.includes(userId)) {
                return;
            }

            this.contendersForKick.push(userId);
            return apiRequest(API_KICK_MEMBER_URL, {'roomId': this.roomId, 'userId': userId})
                .then(() => {
                    this.members = this.members.filter(member => member.id !== userId);
                }).catch((errors) => {
                    errorsHelper.methods.openResponseNotification(errors);
                }).then(() => {
                    this.contendersForKick = this.contendersForKick.filter(id => id !== userId);
                })
        }
    },
    created() {
        this.updateMembers().then(() => {
            this.modalPending = false;
        });
    }
}
</script>

<style scoped>
.refresh-button {
    margin-bottom: 1rem;
}
.members-modal {
    min-width: 40vw;
    min-height: 10vh;
}
</style>

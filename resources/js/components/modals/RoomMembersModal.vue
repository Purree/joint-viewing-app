<template>
    <div class="box box-bordered members-modal">
        <div v-if="!modalPending">
            <o-button @click="usePending(updateMembers, 'updateMembersPending')"
                      variant="danger"
                      class="is-fullwidth refresh-button"
                      :disabled="updateMembersPending"
                      :class="{'is-loading': updateMembersPending}">Refresh</o-button>
            <room-members-row v-for="member in members"
                              :can-control="canControl"
                              :member="member"
                              :is-online="currentMembers.some(onlineMember => onlineMember.id === member.id)"></room-members-row>
        </div>
        <div v-else>
            <o-loading :full-page="false" overlayClass="is-transparent" class="mb-5" :can-cancel="false" :active="modalPending"></o-loading>
        </div>
    </div>
</template>

<script>
import RoomMembersRow from "@/components/room/members/Row";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import {API_GET_ALL_MEMBERS_URL} from "@/api/rooms";
import errorsHelper from "@/mixins/errors.js";
import usePending from "@/mixins/usePending";

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
    },
    data() {
        return {
            members: [],
            updateMembersPending: false,
            modalPending: true,
        }
    },
    methods: {
        updateMembers() {
            return axios.get(replaceDataInUri(API_GET_ALL_MEMBERS_URL, {'roomId': this.roomId}))
                .then((response) => {
                    this.members = response.data;
                }).catch((errors) => {
                    errorsHelper.methods.openResponseNotification(errors);
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

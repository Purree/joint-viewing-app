<template>
    <div class="box box-bordered">
        <o-button variant="danger" class="is-fullwidth refresh-button">Refresh</o-button>
        <room-members-row v-for="member in members"
                          :can-control="canControl || member.id === user.id"
                          :member="member"
                          :is-online="currentMembers.some(onlineMember => onlineMember.id === member.id)"></room-members-row>
    </div>
</template>

<script>
import RoomMembersRow from "@/components/room/members/Row";
import {mapState} from "vuex";

export default {
    name: "RoomMembersModal",
    components: {RoomMembersRow},
    props: {
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
            members: [
                {
                    'id': 1,
                    'name': 'Test',
                    'avatar': '',
                },
                {
                    'id': 2,
                    'name': 'фыввыфывфыфвывфыфвыфвдвыфдыдалдыавфлдавылджавфылждавдлжфваыжлдфваыдлжажвфыдлавыфждлфыввыфывфыфвывфыфвыфвдвыфдыдалдыавфлдавылджавфылждавдлжфваыжлдфваыдлжажвфыдлавыфждлфыввыфывфыфвывфыфвыфвдвыфдыдалдыавфлдавылджавфылждавдлжфваыжлдфваыдлжажвфыдлавыфждл',
                    'avatar': 'profile-photos/$2y$10$4pVVys2RuIM6p7GA21nVnQkBEVf5bn3XxccJ5TxJhCjnVRrUmC.jpg',
                },
            ],
        }
    },
    computed: {
        ...mapState('auth', ['user']),
    },
}
</script>

<style scoped>
    .refresh-button {
        margin-bottom: 1rem;
    }
</style>

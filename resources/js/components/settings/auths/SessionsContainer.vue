<template>
    <div class="divider">Sessions</div>

    <columns :columns="['IP', 'User Agent', 'Last activity']"></columns>
    <div v-for="session in sessions" :key="session.id">
        <hr/>
        <columns :columns="[
            session.ip_address,
            session.user_agent,
            this.formatDate(session.last_activity),
        ]">
            <div class="column">
                <revoke-auth-button :deleting-auths="deletingSessions" @delete="deleteSession" :auth-id="session.id"/>
            </div>
        </columns>
    </div>
</template>

<script>
import RevokeAuthButton from "@/components/settings/auths/RevokeAuthButton";
import Columns from "@/components/Columns";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";
import {mapState} from "vuex";
import {API_DELETE_SESSIONS_URL} from "@/api/sessions";

export default {
    name: "SessionsContainer",
    components: {Columns, RevokeAuthButton},
    emits: ['updateSessions'],
    props: ['sessions'],
    mixins: [replaceDataInUri],
    data() {
        return {
            deletingSessions: []
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    },
    methods: {
        formatDate(dateString) {
            return new Date(dateString * 1000).toLocaleString();
        },
        deleteSession(id) {
            if (!this.deletingSessions.includes(id)) {
                this.deletingSessions.push(id);

                axios.delete(
                    replaceDataInUri(API_DELETE_SESSIONS_URL, {'userId': this.user.id, 'sessionId': id})
                ).then((response) => {
                    if (response.data.logout) {
                        this.$store.dispatch('auth/logout');
                    }

                    this.$emit('updateSessions')
                }).catch(errors => {
                    Object.values(getErrorsFromResponse(errors)).forEach((error) => {
                        this.$oruga.notification.open({
                            duration: 15000,
                            message: error[0],
                            position: 'bottom-right',
                            variant: 'danger',
                            closable: true
                        })
                    })
                }).then(() => {
                    this.deletingSessions.splice(this.deletingSessions.indexOf(id), 1)
                })
            }
        }
    }
}
</script>

<style scoped>

</style>

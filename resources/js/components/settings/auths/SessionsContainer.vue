<template>
    <auth-container :divider-text="'Sessions'"
                    :header-columns="['IP', 'User Agent', 'Last activity', 'Actions']"
                    :array-keys="[
                        'ip_address',
                        'user_agent',
                        {'name': 'last_activity', 'action': formatDate}
                    ]"
                    :auths="sessions"
                    :deleting-auths="deletingSessions"
                    :delete-request-params="{'uri': deleteUri}"
                    @update="this.$emit('updateSessions')"></auth-container>
</template>

<script>
import replaceDataInUri from "@/mixins/replaceDataInUri.js";
import {API_DELETE_SESSIONS_URL} from "@/api/sessions.js";
import AuthContainer from "@/components/settings/auths/AuthContainer.vue";
import formatDate from "@/mixins/formatDate.js";

export default {
    name: "SessionsContainer",
    components: {AuthContainer},
    emits: ['updateSessions'],
    props: ['sessions'],
    mixins: [replaceDataInUri, formatDate],
    data() {
        return {
            deletingSessions: [],
            deleteUri: API_DELETE_SESSIONS_URL
        }
    }
}
</script>

<style scoped>

</style>

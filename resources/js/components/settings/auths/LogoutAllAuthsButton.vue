<template>
    <submit-button :pending="pending" :text="'Log out all devices'"
                   class="is-fullwidth" :is-loading="pending" :variant="'basic'"
                   :send-form="logout"></submit-button>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";
import {API_DELETE_ALL_TOKENS_URL} from "@/api/tokens";
import {mapState} from "vuex";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import {API_DELETE_ALL_SESSIONS_URL} from "@/api/sessions";

export default {
    name: "LogoutAllAuthsButton",
    components: {SubmitButton},
    mixins: [replaceDataInUri],
    data() {
        return {
            pending: false
        }
    },
    methods: {
        async logout() {
            if (this.pending === false) {
                this.pending = true;

                await Promise.all([this.logoutTokens(), this.logoutSessions()])

                this.$store.dispatch('auth/logout')

                this.$router.push({ name: 'Login' })
            }
        },
        logoutTokens() {
            return axios.delete(replaceDataInUri(API_DELETE_ALL_TOKENS_URL, {'id': this.user.id})).catch(errors => {
                console.log(errors.response)
            })
        },
        logoutSessions() {
            return axios.delete(replaceDataInUri(API_DELETE_ALL_SESSIONS_URL, {'id': this.user.id})).catch(errors => {
                console.log(errors.response)
            })
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>

</style>

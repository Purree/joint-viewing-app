<template>
    <divider>Authorizations</divider>

    <ErrorMessage :errors="errors"></ErrorMessage>

    <tokens-container @update-tokens="loadTokens" v-if="auths.tokens && auths.tokens.length !== 0"
                      :tokens="auths.tokens"></tokens-container>

    <sessions-container @update-sessions="loadSessions"
                        v-if="auths.sessions && auths.sessions.length !== 0"
                        :sessions="auths.sessions"></sessions-container>

    <div class="is-flex-desktop">
        <submit-button :pending="isAuthsLoading" :text="buttonText"
                       class="is-fullwidth" :is-loading="isAuthsLoading" :variant="'basic'"
                       @click="usePending(loadAuths, 'isAuthsLoading')"></submit-button>
        <logout-all-auths-button/>
    </div>
</template>

<script>
import SubmitButton from "@/components/SubmitButton.vue";
import {API_SHOW_ALL_TOKENS_URL} from "@/api/tokens.js";
import {mapState} from "vuex";
import ErrorMessage from "@/components/errors/ErrorMessage.vue";
import errorsHelper from "@/mixins/errors.js";
import TokensContainer from "@/components/settings/auths/TokensContainer.vue";
import LogoutAllAuthsButton from "@/components/settings/auths/LogoutAllAuthsButton.vue";
import {API_SHOW_ALL_SESSIONS_URL} from "@/api/sessions.js";
import replaceDataInUri from "@/mixins/replaceDataInUri.js";
import SessionsContainer from "@/components/settings/auths/SessionsContainer.vue";
import usePending from "@/mixins/usePending.js";
import Divider from "@/components/Divider";

export default {
    name: "AuthsSettingsBlock",
    components: {SessionsContainer, LogoutAllAuthsButton, TokensContainer, SubmitButton, ErrorMessage, Divider},
    mixins: [errorsHelper, replaceDataInUri, usePending],
    data() {
        return {
            isAuthsLoading: false,
            auths: {
                'tokens': [],
                'sessions': []
            },
            errors: {},
            buttonText: 'Show authorizations'
        }
    },
    methods: {
        async loadAuths() {
            await this.loadTokens()
            await this.loadSessions()

            this.buttonText = 'Update authorizations'

        },
        loadTokens() {
            return axios.get(replaceDataInUri(API_SHOW_ALL_TOKENS_URL, {'id': this.user.id}))
                .then(response => {
                    this.auths.tokens = response.data
                    this.errors = {}
                })
                .catch((errors) => {
                    this.errors = errorsHelper.methods.getFromResponse(errors);
                })
        },
        loadSessions() {
            return axios.get(replaceDataInUri(API_SHOW_ALL_SESSIONS_URL, {'id': this.user.id}))
                .then(response => {
                    this.auths.sessions = response.data
                    this.errors = {}
                })
                .catch((errors) => {
                    this.errors = errorsHelper.methods.getFromResponse(errors);
                })
        }
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style scoped>

</style>

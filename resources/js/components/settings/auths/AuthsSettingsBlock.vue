<template>
    <div class="divider is-unselectable">Authorizations</div>

    <ErrorMessage :errors="errors"></ErrorMessage>

    <tokens-container @update-tokens="loadTokens" v-if="auths.tokens && auths.tokens.length !== 0"
                      :tokens="auths.tokens"></tokens-container>

    <div class="is-flex-desktop">
        <submit-button :pending="isAuthsLoading" :text="buttonText"
                       class="is-fullwidth" :is-loading="isAuthsLoading" :variant="'basic'"
                       :send-form="loadAuths"></submit-button>
        <logout-all-tokens-button/>
    </div>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";
import {API_SHOW_ALL_TOKENS_URL} from "@/api/tokens";
import {mapState} from "vuex";
import ErrorMessage from "@/components/errors/ErrorMessage";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";
import TokensContainer from "@/components/settings/auths/TokensContainer";
import LogoutAllTokensButton from "@/components/settings/auths/LogoutAllTokensButton";
import {API_SHOW_ALL_SESSIONS_URL} from "@/api/sessions";
import replaceDataInUri from "@/mixins/replaceDataInUri";

export default {
    name: "AuthsSettingsBlock",
    components: {LogoutAllTokensButton, TokensContainer, SubmitButton, ErrorMessage},
    mixins: [getErrorsFromResponse, replaceDataInUri],
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
            if (!this.isAuthsLoading) {
                this.isAuthsLoading = true

                await this.loadTokens()
                await this.loadSessions()

                this.buttonText = 'Update authorizations'
                this.isAuthsLoading = false
            }
        },
        loadTokens() {
            return axios.get(replaceDataInUri(API_SHOW_ALL_TOKENS_URL, {'id': this.user.id}))
                .then(response => {
                    this.auths.tokens = response.data
                    this.errors = {}
                })
                .catch((errors) => {
                    this.errors = getErrorsFromResponse(errors);
                })
        },
        loadSessions() {
            return axios.get(replaceDataInUri(API_SHOW_ALL_SESSIONS_URL, {'id': this.user.id}))
                .then(response => {
                    this.auths.sessions = response.data
                    this.errors = {}
                })
                .catch((errors) => {
                    this.errors = getErrorsFromResponse(errors);
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

<template>
    <div class="divider is-unselectable">Authorizations</div>

    <ErrorMessage :errors="errors"></ErrorMessage>

    <tokens-container v-if="tokens && tokens.length !== 0" :tokens="tokens"></tokens-container>

    <submit-button :pending="isTokensLoading" :text="buttonText"
                   class="is-fullwidth" :is-loading="isTokensLoading" :variant="'basic'"
                   :send-form="loadTokens"></submit-button>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";
import {API_PASSWORD_RECOVERY_URL} from "@/api/tokens";
import {mapState} from "vuex";
import ErrorMessage from "@/components/errors/ErrorMessage";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";
import TokensContainer from "@/components/settings/tokens/TokensContainer";

export default {
    name: "TokensSettingsBlock",
    components: {TokensContainer, SubmitButton, ErrorMessage},
    mixins: [getErrorsFromResponse],
    data() {
        return {
            isTokensLoading: false,
            tokens: [],
            errors: {},
            buttonText: 'Show authorizations'
        }
    },
    methods: {
        loadTokens() {
            if (!this.isTokensLoading) {
                this.isTokensLoading = true
                axios.get(API_PASSWORD_RECOVERY_URL.replace('{id}', this.user.id))
                    .then(response => {
                        this.tokens = response.data
                        this.errors = {}
                        this.buttonText = 'Update authorizations'
                    })
                    .catch((errors) => {
                        this.errors = getErrorsFromResponse(errors);
                    })
                    .then(() => {
                        this.isTokensLoading = false
                    })
            }
        }
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style scoped>

</style>

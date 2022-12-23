<template>
    <div>
        <two-factor-header>
            You successfully enable two-factor authentication.
        </two-factor-header>

        <two-factor-content>
            <div>Two-factor authentication is enabled. Scan the QR code with the authentication app on your phone and
                write code in field below.
            </div>
            <qr-code></qr-code>

            <error-message :errors="errors"></error-message>
            <o-input v-model="this.verifyCode" placeholder="Code" :disabled="verifyPending"
                     @submit.prevent="usePending(verifyTwoFactor, 'verifyPending')"></o-input>
        </two-factor-content>

        <submit-button @click="usePending(verifyTwoFactor, 'verifyPending')"
                       :text="'Verify two-factor code'"
                       :is-loading="verifyPending"
                       :pending="verifyPending"
                       class="is-fullwidth mb-3"></submit-button>
        <turn-off-two-factor-button :disable-pending="disablePending"
                                    @disable-two-factor="$emit('disableTwoFactor')"></turn-off-two-factor-button>
    </div>
</template>

<script>
import TwoFactorHeader from "@/components/settings/two-factor/TwoFactorHeader.vue";
import RecoveryCodes from "@/components/settings/two-factor/RecoveryCodes.vue";
import TwoFactorContent from "@/components/settings/two-factor/TwoFactorContent.vue";
import QrCode from "@/components/settings/two-factor/QrCode.vue";
import EnabledTwoFactorButtons from "@/components/settings/two-factor/EnabledTwoFactorButtons.vue";
import TurnOffTwoFactorButton from "@/components/settings/two-factor/TurnOffTwoFactorButton.vue";
import SubmitButton from "@/components/SubmitButton.vue";
import usePending from "@/mixins/usePending";
import apiRequest from "@/helpers/apiRequest";
import {API_TWO_FACTOR_VERIFY_URL} from "@/api/twoFactor";
import errorsHelper from "@/mixins/errors";
import ErrorMessage from "@/components/errors/ErrorMessage.vue";
import {mapState} from "vuex";

export default {
    name: "RecentlyEnabledTwoFactorBlock",
    components: {
        ErrorMessage,
        SubmitButton,
        TurnOffTwoFactorButton,
        EnabledTwoFactorButtons, QrCode, TwoFactorContent, TwoFactorHeader, RecoveryCodes
    },
    mixins: [usePending],
    data() {
        return {
            verifyPending: false,
            verifyCode: '',
            errors: {}
        }
    },
    methods: {
        verifyTwoFactor() {
            return apiRequest(
                API_TWO_FACTOR_VERIFY_URL,
                {'user': this.user.id},
                {'code': this.verifyCode}
            )
                .then(() => {
                    this.$emit('twoFactorVerified');
                })
                .catch((errors) => {
                    this.errors = errorsHelper.methods.getFromResponse(errors);
                    console.log(errors.response);
                })
        }
    },
    emits: ['disableTwoFactor', 'updateRecoveryCodes', 'twoFactorVerified'],
    props: ['disablePending', 'updateRecoveryCodesPending'],
    computed: {
        ...mapState('auth', ['user'])
    },
}
</script>

<style scoped>

</style>

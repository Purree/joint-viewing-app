<template>
    <div>
        <two-factor-header>
            You successfully enable two-factor authentication.
        </two-factor-header>

        <two-factor-content>
            <div>Two-factor authentication is enabled. Scan the QR code with the authentication app on your phone.</div>
            <qr-code></qr-code>
            <recovery-codes :recovery-codes="recoveryCodes"
                            :pending="updateRecoveryCodesPending"/>

        </two-factor-content>

        <enabled-two-factor-buttons @regenerate-codes="$emit('regenerateCodes')"
                                    :regenerate-codes-pending="recoveryCodesPending"
                                    :disable-pending="disablePending"
                                    @disable-two-factor="$emit('disableTwoFactor')"></enabled-two-factor-buttons>
    </div>
</template>

<script>
import TwoFactorHeader from "@/components/settings/two-factor/TwoFactorHeader.vue";
import RecoveryCodes from "@/components/settings/two-factor/RecoveryCodes.vue";
import TwoFactorContent from "@/components/settings/two-factor/TwoFactorContent.vue";
import QrCode from "@/components/settings/two-factor/QrCode.vue";
import EnabledTwoFactorButtons from "@/components/settings/two-factor/EnabledTwoFactorButtons.vue";

export default {
    name: "RecentlyEnabledTwoFactorBlock",
    components: {EnabledTwoFactorButtons, QrCode, TwoFactorContent, TwoFactorHeader, RecoveryCodes},
    emits: ['regenerateCodes', 'disableTwoFactor', 'updateRecoveryCodes'],
    props: ['disablePending', 'recoveryCodesPending', 'recoveryCodes', 'updateRecoveryCodesPending'],
}
</script>

<style scoped>

</style>

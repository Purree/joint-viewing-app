<template>
    <div>
        <two-factor-header>
            You successfully enable two-factor authentication.
        </two-factor-header>

        <two-factor-content>
            <div>Two-factor authentication is enabled. Scan the QR code with the authentication app on your phone.</div>
            <qr-code></qr-code>
            <recovery-codes ref="recoveryCodes"/>

        </two-factor-content>

        <enabled-two-factor-buttons @regenerate-codes="regenerateCodes"
                                    :regenerate-codes-pending="regenerateCodesPending"
                                    :disable-pending="disablePending"
                                    @disable-two-factor="$emit('disableTwoFactor')"></enabled-two-factor-buttons>
    </div>
</template>

<script>
import TwoFactorHeader from "@/components/settings/two-factor/TwoFactorHeader";
import RecoveryCodes from "@/components/settings/two-factor/RecoveryCodes";
import TwoFactorContent from "@/components/settings/two-factor/TwoFactorContent";
import QrCode from "@/components/settings/two-factor/QrCode";
import EnabledTwoFactorButtons from "@/components/settings/two-factor/EnabledTwoFactorButtons";

export default {
    name: "RecentlyEnabledTwoFactorBlock",
    components: {EnabledTwoFactorButtons, QrCode, TwoFactorContent, TwoFactorHeader, RecoveryCodes},
    emits: ['regenerateCodes', 'disableTwoFactor'],
    props: ['disablePending'],
    data() {
        return {
            regenerateCodesPending: false
        }
    },
    methods: {
        regenerateCodes() {
            this.regenerateCodesPending = true

            this.$emit('regenerateCodes',
                () => {
                    this.$refs.recoveryCodes.updateCodes()
                    this.regenerateCodesPending = false
                }
            )
        }
    }
}
</script>

<style scoped>

</style>
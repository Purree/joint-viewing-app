<template>
    <div>
        <two-factor-header>
            You successfully enable two-factor authentication.
        </two-factor-header>

        <two-factor-content>
            <div>Two-factor authentication is enabled. Scan the QR code with the authentication app on your phone.</div>

            <div v-html="QRCodeSVG"></div>
            <recovery-codes :recovery-codes="recoveryCodes"/>

        </two-factor-content>

        <div class="buttons">
            <o-button class="is-fullwidth">Regenerate recovery codes</o-button>
            <o-button class="is-fullwidth">Turn off</o-button>
        </div>
    </div>
</template>

<script>
import TwoFactorHeader from "@/components/settings/two-factor/TwoFactorHeader";
import RecoveryCodes from "@/components/settings/two-factor/RecoveryCodes";
import TwoFactorContent from "@/components/settings/two-factor/TwoFactorContent";

export default {
    name: "RecentlyEnabledTwoFactorBlock",
    components: {TwoFactorContent, TwoFactorHeader, RecoveryCodes}
}
</script>

<style scoped>

</style>

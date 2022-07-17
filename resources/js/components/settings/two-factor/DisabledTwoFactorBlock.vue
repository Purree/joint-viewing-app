<template>
    <div>
        <two-factor-header>
            You have not enabled two-factor authentication.
        </two-factor-header>

        <two-factor-content>
            <div>
                If two-factor authentication is enabled, you will be prompted to enter a random security token during
                authentication. You can get this token in your phone's Google Authenticator app.
            </div>
        </two-factor-content>

        <o-button @click="this.$emit('enableTwoFactor')" :variant="'success'" class="is-fullwidth">Turn on</o-button>
    </div>
</template>

<script>
import TwoFactorHeader from "@/components/settings/two-factor/TwoFactorHeader";
import TwoFactorContent from "@/components/settings/two-factor/TwoFactorContent";

export default {
    name: "DisabledTwoFactorBlock",
    components: {TwoFactorContent, TwoFactorHeader},
    emits: ['enableTwoFactor']
}
</script>

<style scoped>

</style>

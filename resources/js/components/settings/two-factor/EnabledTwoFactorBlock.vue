<template>
    <div>
        <two-factor-header class="title is-5">
            You have enabled two-factor authentication.
        </two-factor-header>

        <two-factor-content></two-factor-content>

        <o-button class="is-fullwidth">Show recovery codes</o-button>
    </div>
</template>

<script>

import TwoFactorHeader from "@/components/settings/two-factor/TwoFactorHeader";
import RecoveryCodes from "@/components/settings/two-factor/RecoveryCodes";
import TwoFactorContent from "@/components/settings/two-factor/TwoFactorContent";

export default {
    name: "EnabledTwoFactorBlock",
    components: {TwoFactorContent, TwoFactorHeader, RecoveryCodes},
}
</script>

<style scoped>

</style>

<template>
    <div>
        <two-factor-header class="title is-5">
            You have enabled two-factor authentication.
        </two-factor-header>

        <two-factor-content>
            <recovery-codes v-if="showRecoveryCodes"
                            :recovery-codes="recoveryCodes"
                            :pending="updateRecoveryCodesPending"></recovery-codes>
            <o-button v-else class="is-fullwidth" @click="this.$emit('updateRecoveryCodes'); showRecoveryCodes = true">
                Show recovery codes
            </o-button>
        </two-factor-content>

        <enabled-two-factor-buttons @regenerate-codes="$emit('regenerateCodes')"
                                    :regenerate-codes-pending="recoveryCodesPending"
                                    @disable-two-factor="$emit('disableTwoFactor')"
                                    :disable-pending="disablePending"
                                    class="is-fullwidth"></enabled-two-factor-buttons>
    </div>
</template>

<script>

import TwoFactorHeader from "@/components/settings/two-factor/TwoFactorHeader";
import RecoveryCodes from "@/components/settings/two-factor/RecoveryCodes";
import TwoFactorContent from "@/components/settings/two-factor/TwoFactorContent";
import EnabledTwoFactorButtons from "@/components/settings/two-factor/EnabledTwoFactorButtons";

export default {
    name: "EnabledTwoFactorBlock",
    components: {TwoFactorContent, TwoFactorHeader, RecoveryCodes, EnabledTwoFactorButtons},
    emits: ['regenerateCodes', 'disableTwoFactor', 'updateRecoveryCodes'],
    props: ['disablePending', 'recoveryCodesPending', 'recoveryCodes', 'updateRecoveryCodesPending'],
    data() {
        return {
            showRecoveryCodes: false
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div>
        <two-factor-header class="title is-5">
            You have enabled two-factor authentication.
        </two-factor-header>

        <two-factor-content v-if="showRecoveryCodes">
            <recovery-codes ref="recoveryCodes"></recovery-codes>
        </two-factor-content>
        <two-factor-content v-if="!showRecoveryCodes">
            <o-button class="is-fullwidth" @click="showRecoveryCodes = true">Show recovery codes</o-button>
        </two-factor-content>

        <enabled-two-factor-buttons @regenerate-codes="regenerateCodes"
                                    :regenerate-codes-pending="regenerateCodesPending"
                                    @disable-two-factor="$emit('disableTwoFactor')"
                                    v-if="showRecoveryCodes"></enabled-two-factor-buttons>
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
    emits: ['regenerateCodes', 'disableTwoFactor'],
    data() {
        return {
            showRecoveryCodes: false,
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

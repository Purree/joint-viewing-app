<template>
    <div>
        <two-factor-header class="title is-5">
            You have enabled two-factor authentication.
        </two-factor-header>

        <two-factor-content >
            <recovery-codes v-if="showRecoveryCodes" ref="recoveryCodes"></recovery-codes>
            <o-button v-else class="is-fullwidth" @click="showRecoveryCodes = true">Show recovery codes</o-button>
        </two-factor-content>

        <enabled-two-factor-buttons @regenerate-codes="regenerateCodes"
                                    :regenerate-codes-pending="regenerateCodesPending"
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
    emits: ['regenerateCodes', 'disableTwoFactor'],
    props: ['disablePending'],
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
                    this.$refs.recoveryCodes?.updateCodes()
                    this.regenerateCodesPending = false
                }
            )
        }
    }
}
</script>

<style scoped>

</style>

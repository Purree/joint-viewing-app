<template>
    <div class="buttons">
        <submit-button @click="this.$emit('regenerateCodes')"
                       :text="'Regenerate recovery codes'"
                       :is-loading="regenerateCodesPending"
                       :pending="regenerateCodesPending"
                       class="is-fullwidth"
                       :variant="'basic'"></submit-button>
        <turn-off-two-factor-button @disable-two-factor="$emit('disableTwoFactor')"
                                    :disable-pending="disablePending"></turn-off-two-factor-button>
    </div>
</template>

<script>
import SubmitButton from '@/components/SubmitButton.vue'
import TurnOffTwoFactorButton from '@/components/settings/two-factor/TurnOffTwoFactorButton.vue'

export default {
    name: 'EnabledTwoFactorButtons',
    components: { TurnOffTwoFactorButton, SubmitButton },
    emits: ['regenerateCodes', 'disableTwoFactor'],
    props: ['regenerateCodesPending', 'disablePending']
}
</script>

<style scoped>

</style>

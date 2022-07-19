<template>
    <div class="buttons">
        <submit-button @click="this.$emit('regenerateCodes')"
                       :text="'Regenerate recovery codes'"
                       :is-loading="regenerateCodesPending"
                       :pending="regenerateCodesPending"
                       class="is-fullwidth"
                       :variant="'basic'"></submit-button>
        <submit-button @click="this.$emit('disableTwoFactor')"
                       :text="'Turn off two-factor'"
                       :is-loading="disablePending"
                       :pending="disablePending"
                       class="is-fullwidth"
                       :variant="'danger'"></submit-button>
    </div>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";

export default {
    name: "EnabledTwoFactorButtons",
    components: {SubmitButton},
    emits: ['regenerateCodes', 'disableTwoFactor'],
    props: ['regenerateCodesPending', 'disablePending'],
}
</script>

<style scoped>

</style>

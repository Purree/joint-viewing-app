<template>
    <submit-button @click="this.$emit('disableTwoFactor')"
                   :text="'Turn off two-factor'"
                   :is-loading="disablePending"
                   :pending="disablePending"
                   class="is-fullwidth"
                   :variant="'danger'"></submit-button>
</template>

<script>
import SubmitButton from '@/components/SubmitButton.vue'

export default {
    components: { SubmitButton },
    emits: ['disableTwoFactor'],
    name: 'TurnOffTwoFactorButton',
    props: ['disablePending']
}
</script>

<style scoped>

</style>

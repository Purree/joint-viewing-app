<template>
    <div class="buttons">
        <submit-button :send-form="regenerateCodes"
                       :text="'Regenerate recovery codes'"
                       :is-loading="regenerateCodesPending"
                       :pending="regenerateCodesPending"
                       class="is-fullwidth"
                       :variant="'basic'"></submit-button>
        <o-button @click="$emit('disableTwoFactor')" :variant="'danger'" class="is-fullwidth">Turn off two-factor
        </o-button>
    </div>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";

export default {
    name: "EnabledTwoFactorButtons",
    components: {SubmitButton},
    emits: ['regenerateCodes', 'disableTwoFactor'],
    props: ['regenerateCodesPending'],
    methods: {
        regenerateCodes() {
            if (!this.regenerateCodesPending) {
                this.$emit('regenerateCodes')
            }
        }
    }
}
</script>

<style scoped>

</style>

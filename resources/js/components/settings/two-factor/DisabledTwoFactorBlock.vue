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

        <submit-button :pending="pending" :variant="'success'" :is-loading="pending" :text="'Turn on'"
                       @click="this.$emit('enableTwoFactor')" class="is-fullwidth"></submit-button>
    </div>
</template>

<script>
import TwoFactorHeader from "@/components/settings/two-factor/TwoFactorHeader.vue";
import TwoFactorContent from "@/components/settings/two-factor/TwoFactorContent.vue";
import SubmitButton from "@/components/SubmitButton.vue";

export default {
    name: "DisabledTwoFactorBlock",
    components: {SubmitButton, TwoFactorContent, TwoFactorHeader},
    props: ['pending'],
    emits: ['enableTwoFactor']
}
</script>

<style scoped>

</style>

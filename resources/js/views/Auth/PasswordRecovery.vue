<template>
    <ErrorMessage :errors="errors"></ErrorMessage>

    <successful-article v-if="recovery" :text="'Successfully recovered'"></successful-article>

    <FormInput :label="'Secret'" v-model:model-value="form.secret" :placeholder="'I love beautiful women'"
               :type="'text'" :error-condition="'secret' in errors"/>

    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'" :error-condition="'email' in errors"/>

    <FormInput :label="'New Password'" v-model:model-value="form.password" :placeholder="'******'"
               password-reveal :type="'password'" :error-condition="'password' in errors"/>

    <FormInput :label="'New Password Confirmation'" v-model:model-value="form.password_confirmation"
               :placeholder="'******'" password-reveal
               :type="'password'" :error-condition="'password_confirmation' in errors"/>

    <SubmitButton :is-loading="pending" @click="usePending(sendForm)" :pending="pending" :form="form" :text="'Recovery'"/>
</template>

<script>
import SubmitButton from '@/components/SubmitButton.vue'
import FormInput from '@/components/authentication/FormInput.vue'
import ErrorMessage from '@/components/errors/ErrorMessage.vue'
import UserSecretModal from '@/components/modals/UserSecretModal.vue'
import { API_PASSWORD_RECOVERY_URL } from '@/api/auth.js'
import SuccessfulArticle from '@/components/SuccessfulArticle.vue'
import errorsHelper from '@/mixins/errors.js'
import usePending from '@/mixins/usePending.js'
import apiRequest from '@/helpers/apiRequest'

export default {
    name: 'PasswordRecovery',
    components: { SubmitButton, FormInput, ErrorMessage, SuccessfulArticle },
    data() {
        return {
            pending: false,
            recovery: false,
            form: {
                email: null,
                secret: null,
                password: null,
                password_confirmation: null
            },
            errors: {}
        }
    },
    mixins: [usePending],
    methods: {
        promptModal(secret) {
            this.$oruga.modal.open({
                component: UserSecretModal,
                props: {
                    secret
                },
                trapFocus: true,
                canCancel: false
            })
        },
        sendForm() {
            return apiRequest(API_PASSWORD_RECOVERY_URL, {}, this.form)
                .then(response => {
                    this.recovery = true
                    this.errors = {}
                    this.promptModal(response.data.new_secret_phrase)
                })
                .catch(errors => {
                    this.recovery = false
                    this.errors = errorsHelper.methods.getFromResponse(errors)
                })
        }
    }
}
</script>

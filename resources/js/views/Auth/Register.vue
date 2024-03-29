<template>
    <ErrorMessage :errors="errors"></ErrorMessage>

    <successful-article v-if="registered" :text="'Successfully registered'"></successful-article>

    <FormInput :label="'Username'" v-model="form.name" :placeholder="'pure'"
               :type="'text'" :error-condition="'name' in errors"/>

    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'" :error-condition="'email' in errors"/>

    <FormInput :label="'Password'" v-model:model-value="form.password" :placeholder="'******'"
               password-reveal :type="'password'" :error-condition="'password' in errors"/>

    <FormInput :label="'Password Confirmation'" v-model:model-value="form.password_confirmation" password-reveal :placeholder="'******'"
               :type="'password'" :error-condition="'password_confirmation' in errors"/>

    <SubmitButton :is-loading="pending" @click="usePending(sendForm)" :pending="pending" :form="form" :text="'Register'"/>
</template>

<script>
import { API_REGISTRATION_URL } from '@/api/auth.js'
import SubmitButton from '@/components/SubmitButton.vue'
import FormInput from '@/components/authentication/FormInput.vue'
import ErrorMessage from '@/components/errors/ErrorMessage.vue'
import UserSecretModal from '@/components/modals/UserSecretModal.vue'
import SuccessfulArticle from '@/components/SuccessfulArticle.vue'
import errorsHelper from '@/mixins/errors.js'
import usePending from '@/mixins/usePending.js'
import apiRequest from '@/helpers/apiRequest'

export default {
    name: 'Register',
    components: { SuccessfulArticle, ErrorMessage, FormInput, SubmitButton },
    data() {
        return {
            pending: false,
            registered: false,
            form: {
                name: null,
                email: null,
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
            return apiRequest(API_REGISTRATION_URL, {}, this.form)
                .then(response => {
                    this.registered = true
                    this.errors = {}
                    this.promptModal(response.data.secret_phrase)
                })
                .catch(errors => {
                    this.registered = false
                    this.errors = errorsHelper.methods.getFromResponse(errors)
                })
        }
    }
}
</script>

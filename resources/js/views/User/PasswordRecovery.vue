<template>
    <ErrorMessage :errors="errors"></ErrorMessage>

    <successful-article :show-when="recovery" :text="'Successfully recovered'"></successful-article>

    <FormInput :label="'Secret'" v-model:model-value="form.secret" :placeholder="'I love beautiful women'"
               :type="'text'" :error-condition="'secret' in errors"/>

    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'" :error-condition="'email' in errors"/>

    <FormInput :label="'New Password'" v-model:model-value="form.password" :placeholder="'******'"
               :type="'password'" :error-condition="'password' in errors"/>

    <FormInput :label="'New Password Confirmation'" v-model:model-value="form.password_confirmation" :placeholder="'******'"
               :type="'password'" :error-condition="'password_confirmation' in errors"/>

    <SubmitButton :is-loading="pending" :sendForm="sendForm" :pending="pending" :form="form" :text="'Recovery'"/>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";
import FormInput from "@/components/authentication/FormInput";
import ErrorMessage from "@/components/errors/ErrorMessage";
import UserSecretModal from "@/components/modals/UserSecretModal";
import axios from "axios";
import {API_PASSWORD_RECOVERY_URL} from "@/api/auth";
import SuccessfulArticle from "@/components/SuccessfulArticle";

export default {
    name: "PasswordRecovery",
    components: {SubmitButton, FormInput, ErrorMessage, SuccessfulArticle},
    data() {
        return {
            pending: false,
            recovery: false,
            form: {
                email: null,
                secret: null,
                password: null,
                password_confirmation: null,
            },
            errors: {}
        }
    },
    methods: {
        promptModal(secret) {
            this.$oruga.modal.open({
                component: UserSecretModal,
                props: {
                    secret: secret
                },
                trapFocus: true,
                canCancel: false
            })
        },
        sendForm() {
            if (this.pending === false) {
                this.pending = true;
                axios.post(API_PASSWORD_RECOVERY_URL, this.form)
                    .then(response => {
                        this.recovery = true;
                        this.errors = {};
                        this.promptModal(response.data.new_secret_phrase)
                    })
                    .catch(errors => {
                        console.log(errors.response)
                        this.recovery = false;
                        this.errors = errors.response.data?.errors || {'server': [errors.response.data.message]};
                    })
                    .then(() => {
                        this.pending = false;
                    });
            }
        }
    }
}
</script>

<style scoped>

</style>

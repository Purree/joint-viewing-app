<template>
    <ErrorMessage :errors="errors"></ErrorMessage>

    <article v-if="registered" class="message is-primary">
        <div class="message-body">
            Successfully registered
        </div>
    </article>

    <FormInput :label="'Username'" v-model="form.name" :placeholder="'pure'"
               :type="'text'" :error-condition="'name' in errors"/>

    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'" :error-condition="'email' in errors"/>

    <FormInput :label="'Password'" v-model:model-value="form.password" :placeholder="'******'"
               :type="'password'" :error-condition="'password' in errors"/>

    <FormInput :label="'Password Confirmation'" v-model:model-value="form.password_confirmation" :placeholder="'******'"
               :type="'password'" :error-condition="'password_confirmation' in errors"/>

    <SubmitButton :is-loading="pending" :sendForm="sendForm" :pending="pending" :form="form" :text="'Register'"/>
</template>

<script>
import axios from 'axios';
import {API_REGISTRATION_URL} from '@/api/auth';
import AuthenticationLayout from "@/layouts/AuthenticationLayout";
import SubmitButton from "@/components/authentication/SubmitButton";
import FormInput from "@/components/authentication/FormInput";
import ErrorMessage from "@/components/errors/ErrorMessage";
import UserSecretModal from "@/components/modals/UserSecretModal";

export default {
    name: 'Register',
    components: {ErrorMessage, FormInput, SubmitButton, AuthenticationLayout, UserSecretModal},
    data() {
        return {
            pending: false,
            registered: false,
            form: {
                name: null,
                email: null,
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
                axios.post(API_REGISTRATION_URL, this.form)
                    .then(response => {
                        this.registered = true;
                        this.errors = {};
                        this.promptModal(response.data.secret_phrase)
                    })
                    .catch(errors => {
                        console.log(errors.response)
                        this.registered = false;
                        this.errors = errors.response.data.errors;
                    })
                    .then(() => {
                        this.pending = false;
                    });
            }
        }
    }
}
</script>

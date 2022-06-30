<template>
    <ErrorMessage :errors="errors"></ErrorMessage>

    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'" :error-condition="'email' in errors"/>

    <FormInput :label="'Password'" v-model:model-value="form.password" :placeholder="'******'"
               :type="'password'" :error-condition="'password' in errors"/>

    <SubmitButton :is-loading="pending" :sendForm="sendForm" :pending="pending" :form="form" :text="'Login'"/>
</template>

<script>
import axios from 'axios';
import { API_LOGIN_URL } from '@/api/auth';
import AuthenticationLayout from "@/layouts/AuthenticationLayout";
import SubmitButton from "@/components/authentication/SubmitButton";
import FormInput from "@/components/authentication/FormInput";
import ErrorMessage from "@/components/errors/ErrorMessage";
import {API_CURRENT_USER_URL} from "@/api/users";

export default {
    name: 'Login',
    components: {SubmitButton, AuthenticationLayout, FormInput, ErrorMessage},
    data() {
        return {
            pending: false,
            loggedIn: false,
            form: {
                email: null,
                password: null
            },
            errors: {}
        }
    },
    methods: {
        sendForm() {
            if (this.pending === false) {
                this.pending = true;
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post(API_LOGIN_URL, this.form)
                        .then(response => {
                            this.$store.commit('setUserToken', response.data.token);

                            axios.get(API_CURRENT_USER_URL).then((response) => {
                                this.$store.commit('setUser', response.data)

                                if (this.$route.query.redirect) {
                                    this.$router.push(this.$route.query.redirect)
                                } else {
                                    this.$router.push('/')
                                }
                            })
                        })
                        .catch(errors => {
                            console.log(errors.response)
                            this.errors = errors.response.data.errors;
                        })
                        .then(() => {
                            this.pending = false;
                        });
                })
            }
        }
    }
}
</script>

<style scoped>

</style>

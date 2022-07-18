<template>
    <ErrorMessage :errors="errors"></ErrorMessage>

    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'" :error-condition="'email' in errors"/>

    <FormInput :label="'Password'" v-model:model-value="form.password" :placeholder="'******'"
               :type="'password'" :error-condition="'password' in errors"/>

    <div class="field is-grouped is-align-items-center">
        <p class="control">
            <SubmitButton :is-loading="pending" :sendForm="sendForm" :pending="pending" :form="form" :text="'Login'"/>
        </p>
        <p class="control">
            <router-link :to="{ 'name': 'ForgotPassword' }">Forgot password</router-link>
        </p>
    </div>
</template>

<script>
import axios from 'axios';
import {API_LOGIN_URL, API_LOGOUT_URL} from '@/api/auth';
import SubmitButton from "@/components/SubmitButton";
import FormInput from "@/components/authentication/FormInput";
import ErrorMessage from "@/components/errors/ErrorMessage";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";
import loginUser from "@/mixins/loginUser";

export default {
    name: 'Login',
    components: {SubmitButton, FormInput, ErrorMessage},
    mixins: [loginUser],
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

                this.tryToLogin()
            }
        },
        tryToLogin(logoutAndRetryOnForbidden = true) {
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post(API_LOGIN_URL, this.form)
                    .then(response => {
                        if (response.data["two-factor"]) {
                            return this.$router.push({name: 'TwoFactor', query: this.$route.query})
                        }

                        this.loginUser()
                    })
                    .catch(errors => {
                        if (logoutAndRetryOnForbidden && errors.response.status === 403) {
                            axios.post(API_LOGOUT_URL).then(() => {
                                this.tryToLogin(false)
                            }).catch((logoutErrors) => {
                                console.log(logoutErrors)
                            });

                            return;
                        }

                        this.errors = getErrorsFromResponse(errors);
                    })
                    .then(() => {
                        if (logoutAndRetryOnForbidden) {
                            return
                        }

                        this.pending = false;
                    });
            })
        }
    }
}
</script>

<style scoped>

</style>

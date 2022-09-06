<template>
    <ErrorMessage :errors="errors"></ErrorMessage>

    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'" :error-condition="'email' in errors"/>

    <FormInput :label="'Password'" v-model:model-value="form.password" :placeholder="'******'"
               password-reveal :type="'password'" :error-condition="'password' in errors"/>

    <div class="field is-grouped is-align-items-center">
        <p class="control">
            <SubmitButton :is-loading="pending" @click="usePending(sendForm)" :pending="pending" :form="form" :text="'Login'"/>
        </p>
        <p class="control">
            <router-link :to="{ 'name': 'ForgotPassword' }">Forgot password</router-link>
        </p>
    </div>
</template>

<script>
import axios from 'axios';
import {API_LOGIN_URL, API_LOGOUT_URL} from '@/api/auth.js';
import SubmitButton from "@/components/SubmitButton.vue";
import FormInput from "@/components/authentication/FormInput.vue";
import ErrorMessage from "@/components/errors/ErrorMessage.vue";
import errorsHelper from "@/mixins/errors.js";
import loginUser from "@/mixins/loginUser.js";
import usePending from "@/mixins/usePending.js";
import apiRequest from "@/helpers/apiRequest";

export default {
    name: 'Login',
    components: {SubmitButton, FormInput, ErrorMessage},
    mixins: [loginUser, usePending],
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
            return this.tryToLogin()
        },
        tryToLogin(logoutAndRetryOnForbidden = true) {
            return axios.get('/sanctum/csrf-cookie').then(() => {
                return apiRequest(API_LOGIN_URL, this.form)
                    .then(response => {
                        if (response.data["two-factor"]) {
                            return this.$router.push({name: 'TwoFactor', query: this.$route.query})
                        }

                        this.loginUser()
                    })
                    .catch(errors => {
                        if (logoutAndRetryOnForbidden && errors.response.status === 403) {
                            return apiRequest(API_LOGOUT_URL).then(() => {
                                return this.tryToLogin(false)
                            }).catch((logoutErrors) => {
                                console.log(logoutErrors)
                            });
                        }

                        this.errors = errorsHelper.methods.getFromResponse(errors);
                    });
            })
        }
    }
}
</script>

<style scoped>

</style>

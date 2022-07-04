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
import {API_LOGIN_URL} from '@/api/auth';
import SubmitButton from "@/components/SubmitButton";
import FormInput from "@/components/authentication/FormInput";
import ErrorMessage from "@/components/errors/ErrorMessage";
import {API_CURRENT_USER_URL} from "@/api/users";

export default {
    name: 'Login',
    components: {SubmitButton, FormInput, ErrorMessage},
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
                            this.$store.commit('auth/setUserToken', response.data.token);

                            axios.get(API_CURRENT_USER_URL).then((response) => {
                                this.$store.commit('auth/setUser', response.data)

                                if (this.$route.query.redirect) {
                                    this.$router.push(this.$route.query.redirect)
                                } else {
                                    this.$router.push('/')
                                }
                            }).catch(errors => {
                                console.log(errors.response)
                            })
                        })
                        .catch(errors => {
                            console.log(errors.response)
                            this.errors = errors.response.data?.errors || {'server': [errors.response.data.message]};
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

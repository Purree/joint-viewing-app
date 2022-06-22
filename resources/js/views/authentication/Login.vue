<template>
    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'"/>

    <FormInput :label="'Password'" v-model:model-value="form.password" :placeholder="'******'"
               :type="'password'"/>

    <SubmitButton :sendForm="sendForm" :pending="pending" :form="form" :text="'Login'"/>
</template>

<script>
import axios from 'axios';
import { API_LOGIN_URL } from '../../api/auth';
import AuthenticationLayout from "../../layouts/AuthenticationLayout";
import SubmitButton from "../../components/authentication/SubmitButton";
import FormInput from "../../components/authentication/FormInput";

export default {
    name: 'Login',
    components: {SubmitButton, AuthenticationLayout, FormInput},
    data() {
        return {
            pending: false,
            loggedIn: false,
            form: {
                email: null,
                password: null
            }
        }
    },
    methods: {
        sendForm() {
            if (this.pending === false) {
                this.pending = true;
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post(API_LOGIN_URL, this.form)
                        .then(response => {
                            console.log(response)
                            this.loggedIn = true;
                        })
                        .catch(errors => {
                            console.log(errors.response)
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

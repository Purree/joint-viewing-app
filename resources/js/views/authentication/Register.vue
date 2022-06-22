<template>
    <span v-if="registered">Successfully registered</span><br>

    <FormInput :label="'Username'" v-model="form.name" :placeholder="'pure'"
               :type="'text'"/>

    <FormInput :label="'Email'" v-model:model-value="form.email" :placeholder="'alex@example.com'"
               :type="'email'"/>

    <FormInput :label="'Password'" v-model:model-value="form.password" :placeholder="'******'"
               :type="'password'"/>

    <FormInput :label="'Password Confirmation'" v-model:model-value="form.password_confirmation" :placeholder="'******'"
               :type="'password'"/>

    <SubmitButton :sendForm="sendForm" :pending="pending" :form="form" :text="'Register'"/>
</template>

<script>
import axios from 'axios';
import {API_REGISTRATION_URL} from '../../api/auth';
import AuthenticationLayout from "../../layouts/AuthenticationLayout";
import SubmitButton from "../../components/authentication/SubmitButton";
import FormInput from "../../components/authentication/FormInput";

export default {
    name: 'Register',
    components: {FormInput, SubmitButton, AuthenticationLayout},
    data() {
        return {
            pending: false,
            registered: false,
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            }
        }
    },
    methods: {
        sendForm() {
            if (this.pending === false) {
                this.pending = true;
                axios.post(API_REGISTRATION_URL, this.form)
                    .then(response => {
                        this.registered = true;
                    })
                    .catch(errors => {
                        console.log(errors.response)
                    })
                    .then(() => {
                        this.pending = false;
                    });
            }
        }
    }
}
</script>

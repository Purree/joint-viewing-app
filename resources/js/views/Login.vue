<template>
    <section class="box">
        <span v-if="loggedIn">Successfully logged in</span><br>
        <o-field label="Email">
            <o-input v-model="form.email" type="email" placeholder="e.g. alex@example.com"></o-input>
        </o-field>

        <o-field label="Password">
            <o-input v-model="form.password" type="password" placeholder="********"></o-input>
        </o-field>

        <button class="button is-primary" @click="sendForm" :disabled="pending">Sign in</button>
    </section>
</template>

<script>
import axios from 'axios';
import { API_LOGIN_URL } from '../api/auth';

export default {
    name: 'Login',
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

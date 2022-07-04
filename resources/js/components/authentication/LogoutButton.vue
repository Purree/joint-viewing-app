<template>
    <o-button :disabled="pending" variant="light" :class="pending ? 'is-loading' : ''" @click="logout">Logout</o-button>
</template>

<script>
import axios from "axios";
import {API_LOGOUT_URL} from "@/api/auth";

export default {
    name: "LogoutButton",
    props: ['changeStatus'],
    data() {
        return {
            pending: false,
        }
    },
    methods: {
        logout: function () {
            if (this.pending === false) {
                this.pending = true;
                axios.post(API_LOGOUT_URL).then(
                    (response) => {
                        this.$store.commit('auth/setUserToken', null);

                        if (this.changeStatus) {
                            this.changeStatus = !this.changeStatus
                        }

                        this.$router.push({ name: 'Login' })
                    }
                ).catch((error) => {
                    console.log(error.response.data)
                    this.pending = false;
                    for (error in error.response.data.errors) {
                        this.$oruga.notification.open({
                            message: error[0],
                            position: 'top',
                            variant: 'danger',
                            duration: 5000,
                            closable: false
                        })
                    }

                })
            }
        }
    }
}
</script>

<style scoped>

</style>

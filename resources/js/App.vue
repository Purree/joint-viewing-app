<template>
    <main>
        <unable-to-authenticate-modal :is-modal-active="isUnableToAuthenticate"/>
        <AppLayout>
            <router-view></router-view>
        </AppLayout>
    </main>
</template>

<script>

import {API_CURRENT_USER_URL} from "@/api/users";
import UnableToAuthenticateModal from "@/components/errors/UnableToAuthenticateModal";

export default {
    name: 'App',
    components: {UnableToAuthenticateModal},
    data() {
        return {
            isUnableToAuthenticate: false
        }
    },
    beforeCreate() {
        this.$store.commit('setUserToken', localStorage.getItem('auth-token'));

        if (this.$store.getters.isLoggedIn) {
            axios.get(API_CURRENT_USER_URL).then((response) => {
                this.$store.commit('setUser', response.data)
            }).catch((error) => {
                console.log(error.response)
                this.isUnableToAuthenticate = true
            })
        }
    },
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition-property: opacity;
    transition-duration: 0.25s;
}

.fade-enter-active {
    transition-delay: 0.25s;
}

.fade-enter, .fade-leave-active {
    opacity: 0
}
</style>

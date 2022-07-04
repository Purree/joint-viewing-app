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
import UnableToAuthenticateModal from "@/components/modals/UnableToAuthenticateModal";
import changeTheme from "@/mixins/changeTheme";

export default {
    name: 'App',
    components: {UnableToAuthenticateModal},
    mixins: [changeTheme],
    data() {
        return {
            isUnableToAuthenticate: false
        }
    },
    mounted() {
        if (localStorage.getItem('theme') === 'dark' || (localStorage.getItem('theme') !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            this.changeTheme();
        }
    },
    beforeCreate() {
        this.$store.commit('auth/setUserToken', localStorage.getItem('auth-token'));

        if (this.$store.getters['auth/isLoggedIn']) {
            axios.get(API_CURRENT_USER_URL).then((response) => {
                this.$store.commit('auth/setUser', response.data)
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

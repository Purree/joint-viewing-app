<template>
    <main>
        <UnableToAuthenticateModal :is-modal-active="failedToLogin" v-if="failedToLogin"></UnableToAuthenticateModal>
        <AppLayout>
            <router-view></router-view>
        </AppLayout>
    </main>
</template>

<script>

import {API_CURRENT_USER_URL} from "@/api/users";
import changeTheme from "@/mixins/changeTheme";
import {mapState} from "vuex";
import UnableToAuthenticateModal from "@/components/modals/UnableToAuthenticateModal";

export default {
    name: 'App',
    components: {UnableToAuthenticateModal},
    mixins: [changeTheme],
    mounted() {
        if (localStorage.getItem('theme') === 'dark' || (localStorage.getItem('theme') !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            this.changeTheme();
        }

        this.$store.commit('auth/setIsLoggedIn', localStorage.getItem('isLoggedIn'));

        if (this.isLoggedIn) {
            axios.get(API_CURRENT_USER_URL).then((response) => {
                this.$store.commit('auth/setUser', response.data)
            }).catch((error) => {
                console.log(error.response)

                if (error.response.status === 401) {
                    this.$store.commit('auth/setIsLoggedIn', false);
                    this.$router.push('/login');

                    return;
                }
                this.failedToLogin = true
            })
        }
    },
    data() {
        return {
            failedToLogin: false
        }
    },
    computed: {
        ...mapState('auth', ['isLoggedIn'])
    }
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

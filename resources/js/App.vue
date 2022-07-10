<template>
    <main>
        <AppLayout>
            <router-view></router-view>
        </AppLayout>
    </main>
</template>

<script>

import {API_CURRENT_USER_URL} from "@/api/users";
import changeTheme from "@/mixins/changeTheme";

export default {
    name: 'App',
    mixins: [changeTheme],
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

                this.$store.dispatch('auth/logout');
            })
        }
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

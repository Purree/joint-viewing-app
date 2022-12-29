<template>
    <main>
        <UnableToAuthenticateModal v-model:is-modal-active="failedToLogin" v-if="failedToLogin"></UnableToAuthenticateModal>
        <AppLayout v-if="isLoaded">
            <router-view></router-view>
        </AppLayout>
        <p v-else class="is-relative">
            <o-loading :active="!isLoaded"
                       :can-cancel="false"
                       :full-page="true"
                       animation="fade"
                       icon="spinner"></o-loading>
        </p>
    </main>
</template>

<script>

import { API_CURRENT_USER_URL } from '@/api/users.js'
import changeTheme from '@/mixins/changeTheme.js'
import { mapState } from 'vuex'
import UnableToAuthenticateModal from '@/components/modals/UnableToAuthenticateModal.vue'
import apiRequest from '@/helpers/apiRequest'

export default {
    name: 'App',
    components: { UnableToAuthenticateModal },
    mixins: [changeTheme],
    mounted() {
        if (localStorage.getItem('theme') === 'dark' || (localStorage.getItem('theme') !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            this.changeTheme()
        }

        this.$store.commit('auth/setIsLoggedIn', localStorage.getItem('isLoggedIn'))

        if (this.isLoggedIn) {
            apiRequest(API_CURRENT_USER_URL).then((response) => {
                this.$store.commit('auth/setUser', response.data)
            }).catch((error) => {
                console.log(error.response)

                if (error.response.status === 401) {
                    this.$store.commit('auth/setIsLoggedIn', false)
                    this.$router.push('/login')

                    return
                }
                this.failedToLogin = true
            }).then(() => {
                this.isLoaded = true
            })
        } else {
            this.isLoaded = true
        }
    },
    data() {
        return {
            failedToLogin: false,
            isLoaded: false
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

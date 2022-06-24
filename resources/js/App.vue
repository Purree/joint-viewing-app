<template>
    <main>
        <AppLayout>
            <router-view></router-view>
        </AppLayout>
        <o-loading :full-page="true" :active.sync="isLoading" :can-cancel="true"></o-loading>
    </main>
</template>

<script>
import axios from "axios";
import {API_CURRENT_USER_URL} from "./api/users";

export default {
    name: 'App',
    data() {
        return {
            isLoading: true
        }
    },
    mounted() {
        axios.get(API_CURRENT_USER_URL).then(response => {
            this.$store.commit('setAuthUser', response.data);
        })
            .catch(errors => {
                console.log(errors.response)
                this.$store.commit('setAuthUser', null);
            })
            .then(() => {
                this.isLoading = false;
            });
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

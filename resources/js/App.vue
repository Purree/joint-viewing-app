<template>
    <main>
        <AppLayout>
            <router-view></router-view>
        </AppLayout>
    </main>
</template>

<script>

export default {
    name: 'App',
    beforeCreate() {
        this.$store.commit('setUserToken', localStorage.getItem('auth-token'));
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

<template>
    <router-link :to="{ name: 'Login' }">Login</router-link>
    <router-link :to="{ name: 'Register' }">Register</router-link>
    <main class="py-4">
        <router-view></router-view>
    </main>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style scoped>

</style>

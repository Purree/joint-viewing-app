<template>
    <form class="container is-max-desktop auth-form">
        <div class="box container">
            <div class="tabs is-fullwidth is-toggle">
                <ul :key="route" v-for="route in routes">
                    <li :class="{'is-active': route === this.$route.name}">
                        <router-link :to="{ name: route }">{{ route }}</router-link>
                    </li>
                </ul>
            </div>

            <slot></slot>
        </div>
    </form>
</template>

<script>
export default {
    name: 'AuthenticationLayout',
    data() {
        return {
            routes: ['Login', 'Register']
        }
    }
}
</script>

<style scoped>
.auth-form {
    height: 100vh;
    display: flex;
    align-items: center;
    max-width: 700px;
}
</style>

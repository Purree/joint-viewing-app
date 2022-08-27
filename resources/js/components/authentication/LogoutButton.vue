<template>
    <o-button :disabled="pending" variant="light" :class="{'is-loading' : pending}" @click="usePending(logout)">
        Logout
    </o-button>
</template>

<script>
import usePending from "@/mixins/usePending.js";

export default {
    name: "LogoutButton",
    mixins: [usePending],
    data() {
        return {
            pending: false,
        }
    },
    methods: {
        logout() {
            return this.$store.dispatch('auth/logout');
        }
    }
}
</script>

<style scoped>

</style>

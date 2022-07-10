<template>
    <o-button :disabled="pending" variant="light" :class="pending ? 'is-loading' : ''" @click="logout">Logout</o-button>
</template>

<script>
export default {
    name: "LogoutButton",
    data() {
        return {
            pending: false,
        }
    },
    methods: {
        logout: function () {
            if (this.pending === false) {
                this.pending = true;

                this.$store.dispatch('auth/logout');
            }
        }
    }
}
</script>

<style scoped>

</style>

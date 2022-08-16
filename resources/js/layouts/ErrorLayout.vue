<template>
    <div class="is-absolute home-icon">
        <router-link :to="{ 'name': 'Rooms' }">
            <o-icon pack="fas" icon="home" size="large"> </o-icon>
        </router-link>
    </div>
    <slot></slot>
</template>

<script>
export default {
    name: "ErrorLayout"
}
</script>

<style scoped>
.home-icon {
    left: 10px;
    top: 10px;
}
</style>

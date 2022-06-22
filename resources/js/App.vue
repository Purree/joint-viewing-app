<template>
    <main>
        <AppLayout>
            <router-view v-slot="{ Component, route }">
                <transition :name="route.meta.transition || 'fade'">
                    <component :is="Component" />
                </transition>
            </router-view>
        </AppLayout>
    </main>
</template>

<script>
    export default {
        name: 'App',
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

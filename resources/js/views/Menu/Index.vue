<template>
    <router-view v-slot="{ Component, route }">
        <Transition :name="route.meta.childTransition || 'fade'">
            <div :key="route.fullPath">
                <component :is="Component" />
            </div>
        </Transition>
    </router-view>
</template>

<script>
export default {
    name: "Index"
}
</script>

<style scoped>

</style>

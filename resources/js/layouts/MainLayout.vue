<template>
    <Header/>
    <div class="is-fullheight container box border-0 is-under-header">
        <slot></slot>
    </div>
</template>

<script>
import Header from "@/components/Header.vue";

export default {
    name: "MainLayout",
    components: {Header}
}
</script>

<style scoped>

</style>

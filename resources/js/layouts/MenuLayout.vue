<template>
    <Header/>
    <div class="is-fullheight container page-content border-0 is-under-header">
        <slot></slot>
    </div>
</template>

<script>
import Header from "../components/Header";

export default {
    name: "MenuLayout",
    components: {Header}
}
</script>

<style scoped>

</style>

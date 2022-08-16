<template>
    <sidebar></sidebar>

    <div class="is-flex main-content container box is-radiusless">
        <slot></slot>
    </div>
</template>

<script>
import Sidebar from "@/components/Sidebar";
export default{
    name: "RoomLayout",
    components: {Sidebar}
}
</script>

<style lang="scss">
.main-content {
    &, & > * {
        width: 100%;
    }

    height: 100vh;
}
</style>

<template>
    <sidebar></sidebar>

    <div class="is-flex main-content container box is-radiusless">
        <slot></slot>
    </div>
</template>

<script>
import Sidebar from '@/components/Sidebar'

export default {
    name: 'RoomLayout',
    components: { Sidebar }
}
</script>

<style lang="scss" scoped>
.main-content {
    min-height: 100vh;
    max-height: 100vh;
}
</style>

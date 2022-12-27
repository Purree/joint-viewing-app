<template>
    <Header/>
    <div class="is-flex main-content is-fullheight container box is-radiusless is-under-header">
        <slot></slot>
    </div>
</template>

<script>
import Header from '@/components/Header.vue'

export default {
    name: 'MainLayout',
    components: { Header }
}
</script>

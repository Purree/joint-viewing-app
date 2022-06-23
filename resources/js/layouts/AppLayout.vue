<template>
    <Transition :name="this.$route.meta.transition || 'fade'">
        <div :key="this.$route.name">
            <component :is="layout">
                <slot/>
            </component>
        </div>
    </Transition>
</template>

<script>
import AppLayoutDefault from './AppLayoutDefault'

export default {
    name: "AppLayout",
    data: () => ({
        layout: AppLayoutDefault
    }),
    watch: {
        $route: {
            immediate: true,
            async handler(route) {
                try {
                    const component = await import(`./${route.meta.layout}.vue`)
                    this.layout = component?.default || AppLayoutDefault
                } catch (e) {
                    this.layout = AppLayoutDefault
                }
            }
        }
    }
}
</script>

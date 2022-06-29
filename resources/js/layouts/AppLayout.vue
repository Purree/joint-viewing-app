<template>
    <Transition :name="this.$route.meta.transition || 'fade'">
        <div :key="this.$route?.matched[0]?.name || Math.random()">
            <component :is="layout">
                <slot/>
            </component>
        </div>
    </Transition>
</template>

<script>
import AppLayoutDefault from './AppLayoutDefault'
import {shallowRef} from 'vue';

export default {
    name: "AppLayout",
    data: () => ({
        layout: shallowRef(AppLayoutDefault),
        previousLayout: null
    }),
    watch: {
        $route: {
            immediate: true,
            async handler(route) {
                try {
                    if (this.previousLayout === route.meta.layout) {
                        return
                    }

                    this.previousLayout = route.meta.layout
                    const component = await import(`./${route.meta.layout}.vue`)
                    this.layout = shallowRef(component?.default || AppLayoutDefault)
                } catch (e) {
                    this.layout = shallowRef(AppLayoutDefault);
                }
            }
        }
    }
}
</script>

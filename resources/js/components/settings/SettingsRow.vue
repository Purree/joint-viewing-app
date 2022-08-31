<template>
    <div class="columns">
        <div class="column is-justify-content-center is-flex has-text-centered is-align-items-center">
            {{ propertyName }}
        </div>
        <div class="column is-flex is-justify-content-center is-align-items-center" :class="propertyStyles">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "SettingsRow",
    props: ['propertyStyles', 'propertyName']
}
</script>

<style scoped>

</style>

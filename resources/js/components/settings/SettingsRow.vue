<template>
    <div class="columns">
        <div class="column is-justify-content-end is-flex has-text-right is-align-items-center">
            {{ propertyName }}
        </div>
        <div class="column" :class="propertyStyles">
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

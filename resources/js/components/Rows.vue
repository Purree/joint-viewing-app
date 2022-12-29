<template>
    <div class="columns">
        <div :key="column" class="column" v-for="column in columns">
            {{ column }}
        </div>
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: ['columns'],
    name: 'Columns'
}
</script>

<style scoped>
    .column {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .columns:last-child {
        margin-bottom: 0!important;
    }
</style>

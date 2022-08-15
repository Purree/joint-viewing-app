<template>
    <div class="queue-content is-relative box">
        <div class="is-absolute">
            <o-button iconRightClass="regular" icon-right="arrow-right" @click="$emit('closeQueue')"></o-button>
        </div>
        <div>

        </div>
    </div>
</template>

<script>
export default {
    name: "Queue"
}
</script>

<style scoped>
.queue-content {
    margin-top: 10px;
    height: calc(100% - 10px);
}
</style>

<template>
    <div class="is-relative box">
        <div class="is-absolute">
            <o-button iconRightClass="regular" icon-right="arrow-right" @click="$emit('closeChat')"></o-button>
        </div>
        <div>

        </div>
    </div>
</template>

<script>
export default {
    name: "Chat",
    emits: ['closeChat'],
}
</script>

<style scoped>
.chat {
    margin-left: 10px;
    width: calc(50% - 10px);
}
</style>

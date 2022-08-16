<template>
    <div class="is-relative box">
        <div class="is-fixed close-chat-button">
            <o-button iconRightClass="regular" icon-right="close" @click="$emit('closeChat')"></o-button>
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
.close-chat-button {
    margin-left: -1.25rem;
    margin-top: -1.25rem;
}
</style>

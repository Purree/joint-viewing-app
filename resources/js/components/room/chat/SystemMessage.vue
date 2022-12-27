<template>
    <div class="mt-5 mb-5 has-text-info is-size-7 has-text-centered is-italic system-message">
        {{ message.message }}
    </div>
</template>

<script>
export default {
    name: 'SystemChatMessage',
    props: {
        message: {
            type: Object,
            required: true
        }
    }
}
</script>

<style scoped>
    .system-message {
        word-wrap: break-word;
        word-break: break-all;
    }
</style>

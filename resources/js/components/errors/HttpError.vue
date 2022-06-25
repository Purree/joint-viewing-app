<template>
    <div class="is-absolute-center has-text-danger is-size-3-desktop">{{ errorCode }} | {{ errorText }}</div>
</template>

<script>
export default {
    props: ['errorCode', 'errorText'],
    name: "HttpError"
}
</script>

<style scoped>

</style>

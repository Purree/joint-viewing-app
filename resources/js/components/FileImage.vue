<template>
    <div class="file-image" :style="`background-image: url(${fileUrl})`"></div>
</template>

<script>
export default {
    name: 'FileImage',
    props: ['fileUrl']
}
</script>

<style scoped>

</style>

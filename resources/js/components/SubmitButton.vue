<template>
    <o-button :variant="variant || 'primary'" @click.prevent="$emit('click')"
              :disabled="pending || (form && Object.values(form).some((el)=>el === null || el.trim() === ''))"
              :class="isLoading ? 'is-loading ' : ''">
        {{ text }}
    </o-button>
</template>

<script>
export default {
    props: ['pending', 'form', 'text', 'isLoading', 'variant'],
    name: "SubmitButton"
}
</script>

<style scoped>

</style>

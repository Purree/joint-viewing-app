<template>
    <o-button :variant="variant || 'primary'" @click.prevent="$emit('click')"
              nativeType="submit"
              :disabled="pending ||
              (form && Object.values(form).some((el) => el === null ||
              (typeof (el) === 'string' && el.trim() === '')))"
              :class="{'is-loading' : isLoading}">
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

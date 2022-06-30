<template>
    <o-button class="is-primary" @click.prevent="sendForm"
              :disabled="pending || Object.values(form).some((el)=>el == null)"
              :class="isLoading ? 'is-loading' : ''">
        {{ text }}
    </o-button>
</template>

<script>
export default {
    props: ['pending', 'form', 'sendForm', 'text', 'isLoading'],
    name: "SubmitButton"
}
</script>

<style scoped>

</style>

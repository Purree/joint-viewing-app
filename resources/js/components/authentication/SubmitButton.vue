<template>
    <o-button class="is-primary" @click.prevent="sendForm"
              :disabled="pending || Object.values(form).some((el)=>el == null)">{{ text }}
    </o-button>
</template>

<script>
export default {
    props: ['pending', 'form', 'sendForm', 'text'],
    name: "SubmitButton"
}
</script>

<style scoped>

</style>

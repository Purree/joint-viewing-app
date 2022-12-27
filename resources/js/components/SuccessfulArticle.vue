<template>
    <article v-if="showWhen" class="message is-primary">
        <div class="message-header">
            Success
            <button class="delete" @click="showWhen = false"></button>
        </div>
        <div class="message-body">
            {{ text }}
        </div>
    </article>
</template>

<script>
export default {
    name: 'SuccessfulArticle',
    props: ['showWhen', 'text']
}
</script>

<style scoped>

</style>

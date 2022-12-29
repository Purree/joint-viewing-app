<template>
    <article v-if="show" class="message is-primary">
        <div class="message-header">
            Success
            <button class="delete" @click="show = false"></button>
        </div>
        <div class="message-body">
            {{ text }}
        </div>
    </article>
</template>

<script>
export default {
    name: 'SuccessfulArticle',
    props: ['text'],
    data() {
        return {
            show: true
        }
    }
}
</script>

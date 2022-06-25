<template>
    <article class="message is-danger" v-if="Object.keys(errors).length">
        <div class="message-header">
            <p>Error!</p>
        </div>
        <div class="message-body">
            <ul>
                <li v-for="errorGroup in errors">
                    <ul v-if="errorGroup.length > 1">
                        <li v-for="error in errorGroup">
                            {{ error }}
                        </li>
                    </ul>
                    <span v-else>
                        {{ errorGroup[0] }}
                    </span>
                </li>
            </ul>
        </div>
    </article>
</template>

<script>
export default {
    name: "ErrorMessage",
    props: ['errors']
}
</script>

<style scoped>

</style>

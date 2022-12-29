<template>
    <article class="message is-danger" v-if="Object.keys(errors).length">
        <div class="message-header">
            <p>{{ errorHeader || 'Error!' }}</p>
        </div>
        <div class="message-body">
            <ul>
                <li :key="errorGroup.toString().slice(0, 5) + Math.random()" v-for="errorGroup in errors">
                    <ul v-if="errorGroup.length > 1">
                        <li :key="error + Math.random()" v-for="error in errorGroup">
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
    name: 'ErrorMessage',
    props: ['errors', 'errorHeader']
}
</script>

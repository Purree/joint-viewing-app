<template>
    <div class="column box queue-column">
        <div>
            <div>{{ this.name }}</div>
            <div>
                <a :href="this.link">
                    {{ this.link }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "QueueColumn",
    props: {
        name: {
            type: String,
            default: 'Empty name'
        },
        link: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>
.queue-column {
    white-space: nowrap;
    overflow: hidden;
}
</style>

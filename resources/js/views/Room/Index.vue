<template>

</template>

<script>
export default {
    name: "Index",
    mounted() {
        Echo.join(`room.23`)
            .listen('test', (e) => {
                console.log(e);
            });
    }
}
</script>

<style scoped>

</style>

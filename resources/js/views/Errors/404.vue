<template>
    <http-error :error-code="'404'" :error-text="'Not found'"/>
</template>

<script>
import HttpError from "@/components/errors/HttpError";
export default {
    name: "404",
    components: {HttpError}
}
</script>

<style scoped>
</style>

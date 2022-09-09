<template>
    <div class="h-100 w-100">
        <youtube :video-id="videoId" :can-control="canControl"></youtube>
    </div>
</template>

<script>
import Youtube from "@/components/players/Youtube";
export default {
    name: "Player",
    components: {Youtube},
    props: {
        canControl: {
            type: Boolean,
            required: true,
        },
        videoId: {
            type: String,
            required: true,
        },
        host: {
            type: Number,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>

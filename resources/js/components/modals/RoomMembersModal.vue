<template>
    <div class="box box-bordered">

    </div>
</template>

<script>
export default {
    name: "RoomMembersModal",
    props: {
        currentMembers: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            members: [],
        }
    },
}
</script>

<style scoped>

</style>

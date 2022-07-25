<template>
    <submit-button :variant="'danger'" icon-right="trash" :pending="deletingAuths.includes(this.authId)"
                   :is-loading="deletingAuths.includes(this.authId)"
                   @click="this.delete" :text="'Delete'"></submit-button>
</template>

<script>
import SubmitButton from "@/components/SubmitButton.vue";

export default {
    name: "RevokeAuthButton",
    components: {SubmitButton},
    props: ['authId', 'deletingAuths'],
    emits: ['delete'],
    methods: {
        delete() {
            this.$emit('delete', this.authId)
        }
    }
}
</script>

<style scoped>

</style>

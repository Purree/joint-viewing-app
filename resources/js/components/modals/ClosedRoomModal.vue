<template>
    <error-message :errors="errors"/>

    <form action="">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <h3 class="title is-3"> The room requires a password </h3>
            </header>
            <section class="modal-card-body">
                <p></p>
                <form-input label="Enter the password to access the room." type="password" password-reveal
                            v-bind:model-value="password"></form-input>
            </section>
            <footer class="modal-card-foot">
                <o-button variant="danger" @click="$emit('close')">Cancel</o-button>
                <o-button variant="success" @click="$emit('join', {password: this.password})">Try to join</o-button>
            </footer>
        </div>
    </form>
</template>

<script>
import FormInput from "@/components/authentication/FormInput";
import ErrorMessage from "@/components/errors/ErrorMessage";

export default {
    name: "ClosedRoomModal",
    components: {ErrorMessage, FormInput},
    props: ['errors'],
    data() {
        return {
            password: '',
        };
    },
}
</script>

<style scoped>

</style>

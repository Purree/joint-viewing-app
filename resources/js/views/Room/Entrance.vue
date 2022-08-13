<template>
    <form class="container is-max-desktop entrance-form">
        <div class="box container">
            <ErrorMessage :errors="errors"></ErrorMessage>

            <div class="mb-3">You want to enter a secure room, this requires a password, enter it in the field below.
            </div>

            <FormInput password-reveal label="Password" v-model:model-value="password" placeholder="*****"
                       type="password" :error-condition="'password' in errors"/>

            <div class="field is-grouped is-align-items-center">
                <SubmitButton class="is-fullwidth" :is-loading="pending" @click="usePending(tryToJoin)"
                              :pending="pending" :form="{'password': password}" text="Join"/>
            </div>
        </div>
    </form>
</template>

<script>
import ErrorMessage from "@/components/errors/ErrorMessage";
import SubmitButton from "@/components/SubmitButton";
import usePending from "@/mixins/usePending";
import FormInput from "@/components/authentication/FormInput";
import errorsHelper from "@/mixins/errors";

export default {
    name: "Entrance",
    components: {SubmitButton, ErrorMessage, FormInput},
    mixins: [usePending],
    data() {
        return {
            errors: {},
            password: '',
            pending: false,
        }
    },
    methods: {
        async tryToJoin() {
            try {
                let roomData = await this.$store.dispatch('rooms/getData', this.$route.params.id);
                return await this.$store.dispatch('rooms/join', {
                    'id': roomData.id,
                    'link': roomData.link,
                    'password': this.password
                });
            } catch (errors) {
                this.errors = errorsHelper.methods.getFromResponse(errors);
            }
        }
    }
}
</script>

<style scoped>
.entrance-form {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@media screen and (max-width: 739px) {
    .entrance-form {
        width: 95%;
    }
}
</style>

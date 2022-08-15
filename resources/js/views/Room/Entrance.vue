<template>
    <form class="container is-max-desktop entrance-form">
        <div class="box container">
            <div class="is-relative" v-if="isLoading">
                <o-loading overlayClass="is-transparent" :active="true" :can-cancel="false"></o-loading>
            </div>
            <div v-else>
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
        </div>
    </form>
</template>

<script>
import ErrorMessage from "@/components/errors/ErrorMessage";
import SubmitButton from "@/components/SubmitButton";
import usePending from "@/mixins/usePending";
import FormInput from "@/components/authentication/FormInput";
import errorsHelper from "@/mixins/errors";
import {mapState} from "vuex";

export default {
    name: "Entrance",
    components: {SubmitButton, ErrorMessage, FormInput},
    mixins: [usePending],
    data() {
        return {
            errors: {},
            password: '',
            pending: false,
            room: {},
            isLoading: true,
        }
    },
    methods: {
        async tryToJoin() {
            try {
                return await this.$store.dispatch('rooms/join', {
                    'id': this.room.id,
                    'link': this.room.link,
                    'password': this.password
                });
            } catch (errors) {
                this.errors = errorsHelper.methods.getFromResponse(errors);
                return errors;
            }
        },
        throwError(error) {
            if (error?.response?.status) {
                errorsHelper.methods.openResponseNotification(error)
            } else {
                errorsHelper.methods.openNotification(error)
            }

            if (window.history.length > 2) {
                this.$router.back()
            } else {
                this.$router.push('/')
            }
        }
    },
    async mounted() {
        await this.$store.dispatch('rooms/getData', this.$route.params.id).then(response => {
            this.room = response
        }).catch((error) => {
            return this.throwError(error)
        })

        if (!this.room.is_closed || this.current_room?.id) {
            let joinAttempt = await this.tryToJoin();
            if (joinAttempt.response.status >= 400) {
                this.throwError(joinAttempt)
            }
        } else {
            this.isLoading = false;
        }
    },
    computed: {
        ...mapState('rooms', ['current_room']),
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

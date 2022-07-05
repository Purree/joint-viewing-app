<template>
    <div class="divider is-unselectable">User password</div>


    <ErrorMessage :errors="errors"></ErrorMessage>
    <SuccessfulArticle :show-when="successed" :text="'Successfully change password'"></SuccessfulArticle>

    <settings-row :property-name="'New password'">
        <o-input type="password" v-model="form.password"></o-input>
    </settings-row>
    <settings-row :property-name="'Confirm new password'">
        <o-input type="password" v-model="form.password_confirmation"></o-input>
    </settings-row>

    <submit-button :pending="pending" :form="form" :text="'Change password'"
                   class="is-fullwidth" :is-loading="pending" :variant="'basic'"
                   :send-form="changePassword"></submit-button>
</template>

<script>
import SuccessfulArticle from "@/components/SuccessfulArticle";
import SubmitButton from "@/components/SubmitButton";
import SettingsRow from "@/components/settings/SettingsRow";
import ErrorMessage from "@/components/errors/ErrorMessage";
import axios from "axios";
import {API_CHANGE_PASSWORD_URL} from "@/api/users";

export default {
    name: "PasswordSettingsBlock",
    components: {SuccessfulArticle, SubmitButton, SettingsRow, ErrorMessage},
    data() {
        return {
            form: {
                password: null,
                password_confirmation: null,
            },
            pending: false,
            errors: {},
            successed: false
        }
    },
    methods: {
        changePassword() {
            if (this.pending === false) {
                this.pending = true;
                this.successed = false;
                axios.patch(API_CHANGE_PASSWORD_URL, this.form)
                    .then(response => {
                        this.errors = {};
                        this.successed = true;
                    })
                    .catch(errors => {
                        console.log(errors.response)
                        this.errors = errors.response.data?.errors || {'server': [errors.response.data.message]};
                    })
                    .then(() => {
                        this.pending = false;
                    });
            }
        }
    }
}
</script>

<style scoped>

</style>

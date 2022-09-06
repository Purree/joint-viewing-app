<template>
    <divider>User password</divider>


    <ErrorMessage :errors="errors"></ErrorMessage>
    <SuccessfulArticle :show-when="successed" :text="'Successfully change password'"></SuccessfulArticle>

    <settings-row :property-name="'Old password'">
        <o-input password-reveal type="password" v-model="form.old_password"></o-input>
    </settings-row>
    <settings-row :property-name="'New password'">
        <o-input password-reveal type="password" v-model="form.password"></o-input>
    </settings-row>
    <settings-row :property-name="'Confirm new password'">
        <o-input password-reveal type="password" v-model="form.password_confirmation"></o-input>
    </settings-row>

    <submit-button :pending="pending" :form="form" :text="'Change password'"
                   class="is-fullwidth" :is-loading="pending" :variant="'basic'"
                   @click="usePending(changePassword)"></submit-button>
</template>

<script>
import SuccessfulArticle from "@/components/SuccessfulArticle.vue";
import SubmitButton from "@/components/SubmitButton.vue";
import SettingsRow from "@/components/settings/SettingsRow.vue";
import ErrorMessage from "@/components/errors/ErrorMessage.vue";
import {API_CHANGE_PASSWORD_URL} from "@/api/users.js";
import {mapState} from "vuex";
import errorsHelper from "@/mixins/errors.js";
import replaceDataInUri from "@/helpers/replaceDataInUri.js";
import usePending from "@/mixins/usePending.js";
import Divider from "@/components/Divider";
import apiRequest from "@/helpers/apiRequest";

export default {
    name: "PasswordSettingsBlock",
    components: {SuccessfulArticle, SubmitButton, SettingsRow, ErrorMessage, Divider},
    mixins: [replaceDataInUri, usePending],
    data() {
        return {
            form: {
                old_password: null,
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
        this.successed = false;
        return apiRequest(API_CHANGE_PASSWORD_URL, {'id': this.user.id}, this.form)
            .then(() => {
                this.errors = {};
                this.successed = true;
            })
            .catch(errors => {
                this.errors = errorsHelper.methods.getFromResponse(errors);
            })
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>

</style>

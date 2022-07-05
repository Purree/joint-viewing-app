<template>
    <ErrorMessage :errors="mainSettingsErrors"></ErrorMessage>
    <SuccessfulArticle :show-when="mainSettingsSuccessed" :text="'Successfully change name'"></SuccessfulArticle>

    <div class="divider is-unselectable">User settings</div>
    <settings-row :property-name="'Email (hold to show)'" :property-styles="'is-spoiler'">
        {{ this.user.email }}
    </settings-row>
    <settings-row :property-name="'Nickname'">
        <o-input type="text" v-model="currentNickname"></o-input>
    </settings-row>

    <submit-button :pending="mainSettingsPending" :form="mainSettingsForm" :text="'Change username'"
                   class="is-fullwidth" :is-loading="mainSettingsPending" :variant="'basic'"
                   :send-form="changeNickname"></submit-button>

    <div class="divider is-unselectable">User password</div>

    <settings-row :property-name="'New password'">
        <o-input type="password" v-model="passwordSettingsForm.password"></o-input>
    </settings-row>
    <settings-row :property-name="'Confirm new password'">
        <o-input type="password" v-model="passwordSettingsForm.password_confirmation"></o-input>
    </settings-row>

    <submit-button :pending="passwordSettingsPending" :form="passwordSettingsForm" :text="'Change password'"
                   class="is-fullwidth" :is-loading="passwordSettingsPending" :variant="'basic'"
                   :send-form="changePassword"></submit-button>
</template>

<script>
import SettingsRow from "@/components/settings/SettingsRow";
import {mapState} from "vuex";
import SubmitButton from "@/components/SubmitButton";
import axios from "axios";
import {API_CHANGE_NICKNAME_URL} from "@/api/users";
import ErrorMessage from "@/components/errors/ErrorMessage";
import SuccessfulArticle from "@/components/SuccessfulArticle";

export default {
    name: "Settings",
    components: {SuccessfulArticle, SubmitButton, SettingsRow, ErrorMessage},
    data() {
        return {
            mainSettingsForm: {
                nickname: null,
            },
            mainSettingsPending: false,
            mainSettingsErrors: {},
            mainSettingsSuccessed: false,
            passwordSettingsForm: {
                password: null,
                password_confirmation: null,
            },
            passwordSettingsPending: false,

        }
    },
    methods: {
        changeNickname() {
            if (this.mainSettingsPending === false) {
                this.mainSettingsPending = true;
                axios.patch(API_CHANGE_NICKNAME_URL, this.mainSettingsForm)
                    .then(response => {
                        this.$store.commit('auth/setUser', response.data);
                    })
                    .catch(errors => {
                        console.log(errors.response)
                        this.mainSettingsErrors = errors.response.data?.errors || {'server': [errors.response.data.message]};
                    })
                    .then(() => {
                        this.mainSettingsPending = false;
                    });
            }
        },
        changePassword() {

        }
    },
    computed: {
        ...mapState('auth', ['user']),
        currentNickname: {
            get() {
                return this.user.name
            },
            set(value) {
                this.mainSettingsForm.nickname = value
            }
        }
    }
}
</script>

<style scoped>

</style>

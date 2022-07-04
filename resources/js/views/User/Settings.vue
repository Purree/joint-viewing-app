<template>
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

export default {
    name: "Settings",
    components: {SubmitButton, SettingsRow},
    data() {
        return {
            mainSettingsForm: {
                nickname: null,
            },
            mainSettingsPending: false,
            passwordSettingsForm: {
                password: null,
                password_confirmation: null,
            },
            passwordSettingsPending: false,
        }
    },
    methods: {
        changeNickname() {

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

<template>
    <divider>User settings</divider>


    <ErrorMessage :errors="errors"></ErrorMessage>
    <SuccessfulArticle :show-when="successed" :text="'Successfully change name'"></SuccessfulArticle>

    <settings-row :property-name="'Email (hold to show)'" :property-styles="'is-spoiler'">
        {{ this.user.email }}
    </settings-row>
    <settings-row :property-name="'Nickname'">
        <o-input type="text" v-model="currentNickname"></o-input>
    </settings-row>

    <submit-button :pending="pending" :form="form" :text="'Change username'"
                   class="is-fullwidth" :is-loading="pending" :variant="'basic'"
                   @click="usePending(changeNickname)"></submit-button>
</template>

<script>
import SuccessfulArticle from "@/components/SuccessfulArticle.vue";
import SubmitButton from "@/components/SubmitButton.vue";
import SettingsRow from "@/components/settings/SettingsRow.vue";
import ErrorMessage from "@/components/errors/ErrorMessage.vue";
import {API_CHANGE_NICKNAME_URL} from "@/api/users.js";
import {mapState} from "vuex";
import errorsHelper from "@/mixins/errors.js";
import replaceDataInUri from "@/helpers/replaceDataInUri.js";
import usePending from "@/mixins/usePending.js";
import Divider from "@/components/Divider";
import apiRequest from "@/helpers/apiRequest";

export default {
    name: "MainSettingsBlock",
    components: {SuccessfulArticle, SubmitButton, SettingsRow, ErrorMessage, Divider},
    mixins: [replaceDataInUri, usePending],
    data() {
        return {
            form: {
                nickname: null,
            },
            pending: false,
            errors: {},
            successed: false,
        }
    },
    methods: {
        changeNickname() {
            this.successed = false;

            return apiRequest(API_CHANGE_NICKNAME_URL, {'id': this.user.id}, this.form)
                .then(response => {
                    this.$store.commit('auth/setUser', response.data);

                    this.errors = {};
                    this.successed = true;
                })
                .catch(errors => {
                    this.errors = errorsHelper.methods.getFromResponse(errors);
                })
        }
    },
    computed: {
        ...mapState('auth', ['user']),
        currentNickname: {
            get() {
                return this.user.name
            },
            set(value) {
                this.form.nickname = value
            }
        }
    }
}
</script>

<style scoped>

</style>

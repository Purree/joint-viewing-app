<template>
    <div class="divider is-unselectable">User settings</div>


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
import axios from "axios";
import {API_CHANGE_NICKNAME_URL} from "@/api/users.js";
import {mapState} from "vuex";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse.js";
import replaceDataInUri from "@/mixins/replaceDataInUri.js";
import usePending from "@/mixins/usePending.js";

export default {
    name: "MainSettingsBlock",
    components: {SuccessfulArticle, SubmitButton, SettingsRow, ErrorMessage},
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

            return axios.put(replaceDataInUri(API_CHANGE_NICKNAME_URL, {'id': this.user.id}), this.form)
                .then(response => {
                    this.$store.commit('auth/setUser', response.data);

                    this.errors = {};
                    this.successed = true;
                })
                .catch(errors => {
                    this.errors = getErrorsFromResponse(errors);
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

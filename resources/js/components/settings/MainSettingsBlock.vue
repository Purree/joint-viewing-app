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
                   :send-form="changeNickname"></submit-button>
</template>

<script>
import SuccessfulArticle from "@/components/SuccessfulArticle";
import SubmitButton from "@/components/SubmitButton";
import SettingsRow from "@/components/settings/SettingsRow";
import ErrorMessage from "@/components/errors/ErrorMessage";
import axios from "axios";
import {API_CHANGE_NICKNAME_URL} from "@/api/users";
import {mapState} from "vuex";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";
import replaceDataInUri from "@/mixins/replaceDataInUri";

export default {
    name: "MainSettingsBlock",
    components: {SuccessfulArticle, SubmitButton, SettingsRow, ErrorMessage},
    mixins: [replaceDataInUri],
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
            if (this.pending === false) {
                this.pending = true;
                this.successed = false;
                axios.put(replaceDataInUri(API_CHANGE_NICKNAME_URL, {'id': this.user.id}), this.form)
                    .then(response => {
                        this.$store.commit('auth/setUser', response.data);

                        this.errors = {};
                        this.successed = true;
                    })
                    .catch(errors => {
                        this.errors = getErrorsFromResponse(errors);
                    })
                    .then(() => {
                        this.pending = false;
                    });
            }
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

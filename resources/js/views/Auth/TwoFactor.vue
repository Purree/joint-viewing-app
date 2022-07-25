<template>
    <ErrorMessage :errors="errors"></ErrorMessage>

    <div class="mb-5">
        <span>If you have forgotten your recovery key, use your </span>
        <router-link :to="{ 'name': 'ForgotPassword' }">forgotten password key</router-link>
    </div>

    <form @submit.prevent="checkCode">
        <FormInput v-if="is_recovery_codes_used"
                   :label="'Recovery Code'" v-model:model-value="recovery_code"
                   :placeholder="'Enter valid recovery key'"
                   :type="'text'" :error-condition="'code' in errors"/>

        <FormInput v-if="!is_recovery_codes_used"
                   :label="'Auth code'" v-model:model-value="code"
                   :placeholder="'Enter valid auth code'"
                   :type="'text'" :error-condition="'code' in errors"/>

        <div class="field is-grouped is-align-items-center">
            <div class="buttons control">
                <SubmitButton :is-loading="pending" @click="usePending(checkCode)"
                              :pending="pending || (!this.code && !this.recovery_code)" :text="'Login'"/>

                <o-button @click="this.is_recovery_codes_used = !this.is_recovery_codes_used">
                    {{ this.is_recovery_codes_used ? 'Use code' : 'Use recovery key' }}
                </o-button>
            </div>
        </div>
    </form>

</template>

<script>
import SubmitButton from "@/components/SubmitButton.vue";
import FormInput from "@/components/authentication/FormInput.vue";
import ErrorMessage from "@/components/errors/ErrorMessage.vue";
import {API_TWO_FACTOR_LOGIN_URL} from "@/api/twoFactor.js";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse.js";
import loginUser from "@/mixins/loginUser.js";
import usePending from "@/mixins/usePending.js";

export default {
    name: "TwoFactor",
    components: {SubmitButton, FormInput, ErrorMessage},
    mixins: [loginUser, usePending],
    data() {
        return {
            pending: false,
            code: null,
            recovery_code: null,
            errors: {},
            is_recovery_codes_used: false
        }
    },
    methods: {
        checkCode() {
            return axios.post(API_TWO_FACTOR_LOGIN_URL,
                this.is_recovery_codes_used ?
                    {'recovery_code': this.recovery_code} :
                    {'code': this.code})
                .then(() => {
                    this.loginUser()
                })
                .catch(errors => {
                    this.errors = getErrorsFromResponse(errors);
                })
        }
    }
}
</script>

<style scoped>

</style>

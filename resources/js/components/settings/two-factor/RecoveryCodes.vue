<template>
    <div>
        Keep these recovery codes in a safe place. They can be used to regain access to your account if your
        two-factor authentication device is lost.
    </div>
    <div class="box">
        <o-skeleton v-if="pending" :animated="true" :count="8"></o-skeleton>
        <p v-if="!pending" v-for="recoveryCode in recoveryCodes">
            {{ recoveryCode }}
        </p>
    </div>
</template>

<script>
import {API_TWO_FACTOR_GET_RECOVERY_CODES_URL} from "@/api/twoFactor";
import {mapState} from "vuex";
import replaceDataInUri from "@/mixins/replaceDataInUri";

export default {
    name: "RecoveryCodes",
    data() {
        return {
            recoveryCodes: [],
            pending: true
        }
    },
    mounted() {
        this.updateCodes()
    },
    methods: {
        updateCodes() {
            this.pending = true

            axios.get(replaceDataInUri(API_TWO_FACTOR_GET_RECOVERY_CODES_URL, {'user': this.user.id})).then(response => {
                this.recoveryCodes = response.data
            }).catch((errors) => {
                console.log(errors.response)
                this.recoveryCodes = ['Cannot get recovery codes. Try to recreate two-factor.']
            }).then(() => { this.pending = false })
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>
    .box {
        min-width: 192px;
    }
</style>

<template>
    <div class="divider is-unselectable">Two factor authentication</div>

    <enabled-two-factor-block v-if="user.use_two_factor"
                              @regenerate-codes="usePending(regenerateRecoveryCodes, 'regenerateRecoveryCodesPending')"
                              @disable-two-factor="usePending(disableTwoFactor, 'disablingPending')"
                              @update-recovery-codes="usePending(updateRecoveryCodes, 'updateRecoveryCodesPending')"
                              :recovery-codes="recoveryCodes"
                              :disable-pending="disablingPending"
                              :recovery-codes-pending="regenerateRecoveryCodesPending"
                              :update-recovery-codes-pending="updateRecoveryCodesPending"></enabled-two-factor-block>

    <disabled-two-factor-block v-if="!(user.use_two_factor || userEnableTwoFactor)"
                               @enable-two-factor="usePending(enableTwoFactor, 'enablingPending')"
                               :pending="enablingPending"></disabled-two-factor-block>

    <recently-enabled-two-factor-block v-if="userEnableTwoFactor"
                                       @regenerate-codes="usePending(regenerateRecoveryCodes, 'regenerateRecoveryCodesPending')"
                                       @disable-two-factor="usePending(disableTwoFactor, 'disablingPending')"
                                       @update-recovery-codes="usePending(updateRecoveryCodes, 'updateRecoveryCodesPending')"
                                       :recovery-codes="recoveryCodes"
                                       :disable-pending="disablingPending"
                                       :recovery-codes-pending="regenerateRecoveryCodesPending"
                                       :update-recovery-codes-pending="updateRecoveryCodesPending"></recently-enabled-two-factor-block>

</template>

<script>
import {mapState} from "vuex";
import EnabledTwoFactorBlock from "@/components/settings/two-factor/EnabledTwoFactorBlock";
import DisabledTwoFactorBlock from "@/components/settings/two-factor/DisabledTwoFactorBlock";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import {
    API_TWO_FACTOR_DISABLE_URL,
    API_TWO_FACTOR_ENABLE_URL, API_TWO_FACTOR_GET_RECOVERY_CODES_URL,
    API_TWO_FACTOR_REGENERATE_RECOVERY_CODES_URL
} from "@/api/twoFactor";
import RecentlyEnabledTwoFactorBlock from "@/components/settings/two-factor/RecentlyEnabledTwoFactorBlock";
import usePending from "@/mixins/usePending";
import recoveryCodes from "@/components/settings/two-factor/RecoveryCodes";

export default {
    name: "TwoFactorSettingsBlock",
    components: {RecentlyEnabledTwoFactorBlock, DisabledTwoFactorBlock, EnabledTwoFactorBlock},
    computed: {
        ...mapState('auth', ['user'])
    },
    data() {
        return {
            userEnableTwoFactor: false,
            recoveryCodes: [],
            enablingPending: false,
            disablingPending: false,
            regenerateRecoveryCodesPending: false,
            updateRecoveryCodesPending: false
        }
    },
    mixins: [usePending],
    methods: {
        enableTwoFactor() {
            return axios.post(replaceDataInUri(API_TWO_FACTOR_ENABLE_URL, {'user': this.user.id}))
                .then(() => {
                    this.userEnableTwoFactor = true;
                    return this.updateRecoveryCodes();
                })
                .catch((errors) => {
                    console.log(errors.response);
                })
        },
        regenerateRecoveryCodes() {
            return axios.put(replaceDataInUri(API_TWO_FACTOR_REGENERATE_RECOVERY_CODES_URL, {'user': this.user.id}))
                .then(() => {
                    return this.updateRecoveryCodes();
                })
                .catch((errors) => {
                    console.log(errors)
                })
        },
        disableTwoFactor() {
            return axios.delete(replaceDataInUri(API_TWO_FACTOR_DISABLE_URL, {'user': this.user.id}))
                .then(() => {
                    this.user.use_two_factor = this.userEnableTwoFactor = false;
                })
                .catch((errors) => {
                    console.log(errors.response);
                })
        },
        updateRecoveryCodes() {
            return axios.get(replaceDataInUri(API_TWO_FACTOR_GET_RECOVERY_CODES_URL, {'user': this.user.id})).then(response => {
                this.recoveryCodes = response.data
            }).catch((errors) => {
                console.log(errors.response)
                this.recoveryCodes = ['Cannot get recovery codes. Try to recreate two-factor.']
            })
        }
    },
    unmounted() {
        this.user.use_two_factor = this.userEnableTwoFactor
    }
}
</script>

<style scoped>

</style>

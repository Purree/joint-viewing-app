<template>
    <div class="divider is-unselectable">Two factor authentication</div>

    <enabled-two-factor-block v-if="user.use_two_factor"></enabled-two-factor-block>
    <disabled-two-factor-block v-if="!(user.use_two_factor || userEnableTwoFactor)" @enable-two-factor="enableTwoFactor"></disabled-two-factor-block>

    <recently-enabled-two-factor-block v-if="userEnableTwoFactor"></recently-enabled-two-factor-block>

</template>

<script>
import {mapState} from "vuex";
import EnabledTwoFactorBlock from "@/components/settings/two-factor/EnabledTwoFactorBlock";
import DisabledTwoFactorBlock from "@/components/settings/two-factor/DisabledTwoFactorBlock";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import {API_TWO_FACTOR_ENABLE_URL} from "@/api/twoFactor";
import RecentlyEnabledTwoFactorBlock from "@/components/settings/two-factor/RecentlyEnabledTwoFactorBlock";

export default {
    name: "TwoFactorSettingsBlock",
    components: {RecentlyEnabledTwoFactorBlock, DisabledTwoFactorBlock, EnabledTwoFactorBlock},
    computed: {
        ...mapState('auth', ['user'])
    },
    data() {
        return {
            userEnableTwoFactor: false
        }
    },
    methods: {
        enableTwoFactor() {
            return axios.post(replaceDataInUri(API_TWO_FACTOR_ENABLE_URL, {'user': this.user.id}))
                .then(() => {
                    this.userEnableTwoFactor = true;
                })
                .catch((errors) => {
                    console.log(errors.response);
                })
        }
    }
}
</script>

<style scoped>

</style>

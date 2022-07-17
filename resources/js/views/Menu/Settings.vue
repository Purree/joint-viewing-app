<template>
    <main-settings-block></main-settings-block>

    <password-settings-block></password-settings-block>

    <auths-settings-block></auths-settings-block>

    <two-factor-settings-block></two-factor-settings-block>
</template>

<script>
import MainSettingsBlock from "@/components/settings/MainSettingsBlock";
import PasswordSettingsBlock from "@/components/settings/PasswordSettingsBlock";
import AuthsSettingsBlock from "@/components/settings/AuthsSettingsBlock";
import TwoFactorSettingsBlock from "@/components/settings/TwoFactorSettingsBlock";

export default {
    name: "Settings",
    components: {TwoFactorSettingsBlock, AuthsSettingsBlock, PasswordSettingsBlock, MainSettingsBlock},
}
</script>

<style scoped>

</style>

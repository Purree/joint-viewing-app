<template>
    <avatar-settings-block></avatar-settings-block>

    <main-settings-block></main-settings-block>

    <password-settings-block></password-settings-block>

    <auths-settings-block></auths-settings-block>

    <two-factor-settings-block></two-factor-settings-block>
</template>

<script>
import MainSettingsBlock from "@/components/settings/blocks/MainSettingsBlock";
import PasswordSettingsBlock from "@/components/settings/blocks/PasswordSettingsBlock";
import AuthsSettingsBlock from "@/components/settings/blocks/AuthsSettingsBlock";
import TwoFactorSettingsBlock from "@/components/settings/blocks/TwoFactorSettingsBlock";
import AvatarSettingsBlock from "@/components/settings/blocks/AvatarSettingsBlock";

export default {
    name: "Settings",
    components: {
        AvatarSettingsBlock,
        TwoFactorSettingsBlock, AuthsSettingsBlock, PasswordSettingsBlock, MainSettingsBlock},
}
</script>

<style scoped>

</style>

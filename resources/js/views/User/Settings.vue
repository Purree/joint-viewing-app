<template>
    <main-settings-block></main-settings-block>

    <password-settings-block></password-settings-block>

    <auths-settings-block></auths-settings-block>
</template>

<script>
import MainSettingsBlock from "@/components/settings/MainSettingsBlock";
import PasswordSettingsBlock from "@/components/settings/PasswordSettingsBlock";
import AuthsSettingsBlock from "@/components/settings/auths/AuthsSettingsBlock";

export default {
    name: "Settings",
    components: {AuthsSettingsBlock, PasswordSettingsBlock, MainSettingsBlock},
}
</script>

<style scoped>

</style>

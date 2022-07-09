<template>
    <main-settings-block></main-settings-block>

    <password-settings-block></password-settings-block>

    <tokens-settings-block></tokens-settings-block>
</template>

<script>
import MainSettingsBlock from "@/components/settings/MainSettingsBlock";
import PasswordSettingsBlock from "@/components/settings/PasswordSettingsBlock";
import TokensSettingsBlock from "@/components/settings/tokens/TokensSettingsBlock";

export default {
    name: "Settings",
    components: {TokensSettingsBlock, PasswordSettingsBlock, MainSettingsBlock},
}
</script>

<style scoped>

</style>

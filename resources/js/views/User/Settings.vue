<template>
    <main-settings-block></main-settings-block>

    <password-settings-block></password-settings-block>
</template>

<script>
import MainSettingsBlock from "@/components/settings/MainSettingsBlock";
import PasswordSettingsBlock from "@/components/settings/PasswordSettingsBlock";

export default {
    name: "Settings",
    components: {PasswordSettingsBlock, MainSettingsBlock},
}
</script>

<style scoped>

</style>

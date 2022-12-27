<template>
    <avatar-settings-block></avatar-settings-block>

    <main-settings-block></main-settings-block>

    <password-settings-block></password-settings-block>

    <auths-settings-block></auths-settings-block>

    <two-factor-settings-block></two-factor-settings-block>
</template>

<script>
import MainSettingsBlock from '@/components/settings/blocks/MainSettingsBlock.vue'
import PasswordSettingsBlock from '@/components/settings/blocks/PasswordSettingsBlock.vue'
import AuthsSettingsBlock from '@/components/settings/blocks/AuthsSettingsBlock.vue'
import TwoFactorSettingsBlock from '@/components/settings/blocks/TwoFactorSettingsBlock.vue'
import AvatarSettingsBlock from '@/components/settings/blocks/AvatarSettingsBlock.vue'

export default {
    name: 'Settings',
    components: {
        AvatarSettingsBlock,
        TwoFactorSettingsBlock,
        AuthsSettingsBlock,
        PasswordSettingsBlock,
        MainSettingsBlock
    }
}
</script>

<style scoped>

</style>

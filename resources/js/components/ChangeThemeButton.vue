<template>
    <o-button :icon-right="$store.getters.getTheme === 'light' ? 'moon' : 'sun'" @click="changeTheme"></o-button>
</template>

<script>
import changeTheme from "@/mixins/changeTheme.js";

export default {
    name: "ChangeThemeButton",
    mixins: [changeTheme]
}
</script>

<style scoped>

</style>

<template>
    <div>
        <o-button v-if="!isOpened" @click="isOpened=!isOpened" icon-right="bars"
                  class="sidebar-opened-burger is-fixed"></o-button>
        <aside class="navbar is-fixed menu is-flex-direction-column" :class="isOpened ? 'is-opened': 'is-closed'">
            <o-button class="is-fullwidth" @click="isOpened=!isOpened" icon-right="close"></o-button>
            <div class="menu-buttons h-100 w-100 is-flex is-flex-direction-column is-justify-content-space-between">
                <ul class="menu-list">
                    <li v-for="tab in tabs" class="is-clipped">
                        <router-link :to="{'name': tab['route-name']}">
                            {{ tab.text }}
                        </router-link>
                    </li>
                </ul>
                <change-theme-button></change-theme-button>
            </div>
        </aside>
    </div>
</template>

<script>
import Header from "@/components/Header";
import ChangeThemeButton from "@/components/ChangeThemeButton";

export default {
    name: "Sidebar",
    components: {ChangeThemeButton},
    data() {
        return {
            tabs: {},
            isOpened: false
        }
    },
    mounted() {
        this.tabs = {...this.tabs, ...Header.data().tabs}
    }
}
</script>

<style scoped lang="sass">
@import "@@/bulma/prefers-dark/utilities/mixins.sass"
$sidebarBackgroundColor: #dee3ed
$sidebarBackgroundColorDark: #2f3237


+prefers-scheme(dark)
    .menu, .sidebar-opened-burger
        background-color: $sidebarBackgroundColorDark !important

.sidebar-opened-burger
    z-index: 100

.menu
    z-index: 100
    position: fixed
    height: 100vh
    background-color: $sidebarBackgroundColor !important

.menu-buttons
    padding: 8px

.is-opened
    width: 256px

.is-closed
    display: none

@media (max-width: 1024px)
    .menu-buttons
        justify-content: start !important
</style>

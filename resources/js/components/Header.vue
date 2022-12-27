<template>
    <nav class="navbar is-fixed-top has-shadow" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a role="button" @click="isDropdownActive=!isDropdownActive" class="navbar-burger" aria-label="menu"
               aria-expanded="false" data-target="menuNavbar" :class="{'is-active' : isDropdownActive}">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="menuNavbar" class="navbar-menu container" :class="isDropdownActive ? 'is-active' : 'is-hidden-touch'">
            <div class="navbar-start">
                <router-link v-for="tab in tabs" class="navbar-item is-tab" :to="{name: tab['route-name']}"
                             :class="{'is-active' : tab['route-name'] === $route.name}">
                    {{ tab.text }}
                </router-link>
            </div>

            <div class="navbar-end">
                <div class="navbar-item header-nickname is-overflow-hidden">
                    {{ this.user.name || 'Undefined user' }}
                </div>
                <div class="navbar-item pl-0 is-hidden-touch">
                    <user-avatar :avatar-path="this.user?.avatar"></user-avatar>
                </div>
                <div class="navbar-item">
                    <div class="buttons">
                        <change-theme-button></change-theme-button>
                        <logout-button/>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import LogoutButton from '@/components/authentication/LogoutButton.vue'
import ChangeThemeButton from '@/components/ChangeThemeButton.vue'
import { mapState } from 'vuex'
import UserAvatar from '@/components/UserAvatar'

export default {
    name: 'Header',
    components: { UserAvatar, ChangeThemeButton, LogoutButton },
    data() {
        return {
            isDropdownActive: false,
            tabs: {
                Rooms:
                    {
                    	'route-name': 'Rooms',
                    	text: 'Rooms'
                    },
                Settings:
                    {
                    	'route-name': 'Settings',
                    	text: 'Settings'
                    }
            }
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>
.header-nickname {
    max-width: 20ch;
}
</style>

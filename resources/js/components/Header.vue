<template>
    <nav class="navbar is-fixed-top has-shadow" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a role="button" @click="isDropdownActive=!isDropdownActive" class="navbar-burger" aria-label="menu"
               aria-expanded="false" data-target="menuNavbar" :class="isDropdownActive ? 'is-active' : ''">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="menuNavbar" class="navbar-menu container" :class="isDropdownActive ? 'is-active' : 'is-hidden-touch'">
            <div class="navbar-start">
                <router-link v-for="tab in tabs" class="navbar-item is-tab" :to="{name: tab['route-name']}"
                             :class="tab['route-name'] === $route.name ? 'is-active' : ''">
                    {{ tab.text }}
                </router-link>
            </div>

            <div class="navbar-end">
                <div class="navbar-item header-nickname">
                    {{ this.user.name || 'Undefined user' }}
                </div>
                <div class="navbar-item pl-0 is-hidden-touch">
                    <div class="user-avatar"
                         :style="`background-image: url(${ asset(this.user.avatar || 'profile-photos/default.png') })`"></div>
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
import LogoutButton from "@/components/authentication/LogoutButton";
import ChangeThemeButton from "@/components/ChangeThemeButton";
import {mapState} from "vuex";
import asset from "@/mixins/asset";

export default {
    name: "Header",
    components: {ChangeThemeButton, LogoutButton},
    mixins: [asset],
    data() {
        return {
            isDropdownActive: false,
            tabs: {
                'Rooms':
                    {
                        'route-name': 'Rooms',
                        'text': 'Rooms'
                    },
                'Settings':
                    {
                        'route-name': 'Settings',
                        'text': 'Settings'
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
    overflow: hidden;
}
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>

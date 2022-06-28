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
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-light">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Header",
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
    }
}
</script>

<style scoped>

</style>

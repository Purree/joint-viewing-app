export default {
    methods: {
        changeTheme() {
            const page = document.documentElement

            if (page.hasAttribute('data-theme') && page.attributes['data-theme'].value === 'dark') {
                this.$store.commit('setTheme', 'light')
            } else {
                this.$store.commit('setTheme', 'dark')
            }
        }
    }
}

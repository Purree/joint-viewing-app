export default {
    methods: {
        asset(path) {
            const basePath = (window._asset || '') + 'storage/'
            return basePath + path
        }
    }
}

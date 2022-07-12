<template>
    <submit-button :pending="pending" :text="'Log out all devices'"
                   class="is-fullwidth" :is-loading="pending" :variant="'basic'"
                   :send-form="logout"></submit-button>
</template>

<script>
import SubmitButton from "@/components/SubmitButton";
import {API_DELETE_ALL_TOKENS_URL} from "@/api/tokens";
import {mapState} from "vuex";
import replaceDataInUri from "@/mixins/replaceDataInUri";

export default {
    name: "LogoutAllTokensButton",
    components: {SubmitButton},
    mixins: [replaceDataInUri],
    data() {
        return {
            pending: false
        }
    },
    methods: {
        logout() {
            if (this.pending === false) {
                this.pending = true;
                axios.delete(replaceDataInUri(API_DELETE_ALL_TOKENS_URL, {'id': this.user.id})).then(() => {
                    this.$store.dispatch('auth/logout')

                    this.$router.push({ name: 'Login' })
                }).catch( errors => {
                    console.log(errors.response)
                })
            }
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>

</style>

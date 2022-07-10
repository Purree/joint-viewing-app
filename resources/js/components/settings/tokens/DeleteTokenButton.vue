<template>
    <submit-button :variant="'danger'" icon-right="trash" :pending="pending" :is-loading="pending"
                   :send-form="deleteToken" :text="'Delete'"></submit-button>
</template>

<script>
import {API_DELETE_TOKEN_URL} from "@/api/tokens";
import {mapState} from "vuex";
import SubmitButton from "@/components/SubmitButton";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";

export default {
    name: "DeleteTokenButton",
    components: {SubmitButton},
    props: ['tokenId'],
    emits: ['updateTokens'],
    data() {
        return {
            pending: false
        }
    },
    methods: {
        deleteToken() {
            if (this.pending === false) {
                this.pending = true;

                axios.delete(
                    API_DELETE_TOKEN_URL.replace('{userId}', this.user.id)
                        .replace('{tokenId}', this.tokenId)
                ).then((response) => {
                    if (response.data.logout) {
                        this.$store.dispatch('auth/logout');
                    }

                    this.$emit('updateTokens')
                }).catch(errors => {
                    Object.values(getErrorsFromResponse(errors)).forEach((error) => {
                        this.$oruga.notification.open({
                            duration: 15000,
                            message: error[0],
                            position: 'bottom-right',
                            variant: 'danger',
                            closable: true
                        })
                    })
                }).then(() => {
                    this.pending = false
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

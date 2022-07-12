<template>
    <div class="divider">Tokens</div>

    <columns :columns="['Type', 'Abilities', 'Created at', 'Last used at', 'Actions']"></columns>
    <div v-for="token in tokens" :key="token.id">
        <hr/>
        <columns :columns="[
            token.type,
            token.abilities.includes('*') ? 'All' : token.abilities.join(', '),
            this.formatDate(token.created_at),
            token.last_used_at ? this.formatDate(token.last_used_at) : 'Never',
        ]">
            <div class="column">
                <revoke-auth-button :deleting-auths="deletingTokens" @delete="deleteToken" :auth-id="token.id"/>
            </div>
        </columns>
    </div>
</template>

<script>
import RevokeAuthButton from "@/components/settings/auths/RevokeAuthButton";
import Columns from "@/components/Columns";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import {API_DELETE_TOKEN_URL} from "@/api/tokens";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";
import {mapState} from "vuex";

export default {
    name: "TokensContainer",
    components: {Columns, RevokeAuthButton},
    emits: ['updateTokens'],
    props: ['tokens'],
    mixins: [replaceDataInUri],
    data() {
        return {
            deletingTokens: []
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    },
    methods: {
        formatDate(dateString) {
            return new Date(dateString).toLocaleString();
        },
        deleteToken(id) {
            if (!this.deletingTokens.includes(id)) {
                this.deletingTokens.push(id);

                axios.delete(
                    replaceDataInUri(API_DELETE_TOKEN_URL, {'userId': this.user.id, 'tokenId': id})
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
                    this.deletingTokens.splice(this.deletingTokens.indexOf(id), 1)
                })
            }
        }
    }
}
</script>

<style scoped>

</style>

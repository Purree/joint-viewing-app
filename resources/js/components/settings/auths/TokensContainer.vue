<template>
    <auth-container :divider-text="'Tokens'"
                    :header-columns="['Type', 'Abilities', 'Created at', 'Last used at', 'Actions']"
                    :array-keys="[
                        'type',
                        {'name': 'abilities', 'action': (abilities) => abilities.includes('*') ? 'All' : abilities.join(', ')},
                        {'name': 'created_at', 'action': formatDate},
                        {'name': 'last_used_at', 'action': (date) => date ? formatDate(date) : 'Never'}
                    ]"
                    :auths="tokens"
                    :deleting-auths="deletingTokens"
                    :delete-request-params="{'uri': deleteUri}"
                    @update="this.$emit('updateTokens')"></auth-container>
</template>

<script>
import replaceDataInUri from "@/mixins/replaceDataInUri";
import AuthContainer from "@/components/settings/auths/AuthContainer";
import formatDate from "@/mixins/formatDate";
import {API_DELETE_TOKEN_URL} from "@/api/tokens";

export default {
    name: "TokensContainer",
    components: {AuthContainer},
    emits: ['updateTokens'],
    props: ['tokens'],
    mixins: [replaceDataInUri, formatDate],
    data() {
        return {
            deletingTokens: [],
            deleteUri: API_DELETE_TOKEN_URL
        }
    }
}
</script>

<style scoped>

</style>

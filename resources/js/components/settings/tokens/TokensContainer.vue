<template>
    <div class="columns">
        <div class="column">
            Type
        </div>
        <div class="column">
            Abilities
        </div>
        <div class="column">
            Created at
        </div>
        <div class="column">
            Last used at
        </div>
        <div class="column">
            Actions
        </div>
    </div>
    <div v-for="token in tokens" :key="token.id">
        <hr/>
        <div class="columns">
            <div class="column">
                {{ token.type }}
            </div>
            <div class="column">
                {{ token.abilities.includes('*') ? 'All' : token.abilities.join(', ') }}
            </div>
            <div class="column">
                {{ this.formatDate(token.created_at) }}
            </div>
            <div class="column">
                {{ token.last_used_at ? this.formatDate(token.last_used_at) : 'Never' }}
            </div>
            <div class="column">
                <delete-token-button @update-tokens="this.$emit('updateTokens')" :token-id="token.id"/>
            </div>
        </div>
    </div>
</template>

<script>
import DeleteTokenButton from "@/components/settings/tokens/DeleteTokenButton";
export default {
    name: "TokensContainer",
    components: {DeleteTokenButton},
    emits: ['updateTokens'],
    props: ['tokens'],
    methods: {
        formatDate(dateString) {
            return new Date(dateString).toLocaleString();
        }
    }
}
</script>

<style scoped>
    .column {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .columns:last-child {
        margin-bottom: 0!important;
    }
</style>

<template>
    <div class="columns">
        <div class="column">
            Type
        </div>
        <div class="column">
            Abilities
        </div>
        <div class="column">
            Last used at
        </div>
        <div class="column">
            Created at
        </div>
        <div class="column">
            Actions
        </div>
    </div>
    <div v-for="token in tokens">
        <hr/>
        <div class="columns">
            <div class="column">
                {{ token.type }}
            </div>
            <div class="column">
                {{ token.abilities.includes('*') ? 'All' : token.abilities.join(', ') }}
            </div>
            <div class="column">
                {{ token.last_used_at ? this.formatDate(token.last_used_at) : 'Never' }}
            </div>
            <div class="column">
                {{ this.formatDate(token.created_at) }}
            </div>
            <div class="column">
                <o-button variant="danger" icon-right="trash" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TokensContainer",
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
</style>

<template>
    <div>
        Keep these recovery codes in a safe place. They can be used to regain access to your account if your
        two-factor authentication device is lost.
    </div>
    <div class="box has-text-centered">
        <o-skeleton v-if="pending" :animated="true" :count="8"></o-skeleton>
        <p v-if="!pending" v-for="recoveryCode in recoveryCodes">
            {{ recoveryCode }}
        </p>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "RecoveryCodes",
    props: ['recoveryCodes', 'pending'],
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>
    .box {
        min-width: 192px;
    }
</style>

<template>
    <div>
        Keep these recovery codes in a safe place. They can be used to regain access to your account if your
        two-factor authentication device is lost.
    </div>
    <div class="box">
        <p v-for="recoveryCode in recoveryCodes">
            {{ recoveryCode }}
        </p>
    </div>
</template>

<script>
export default {
    name: "RecoveryCodes",
    props: ['recoveryCodes']
}
</script>

<style scoped>

</style>

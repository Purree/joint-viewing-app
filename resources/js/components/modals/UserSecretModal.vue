<template>
    <form action="">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <h3 class="title is-3"> THIS IS VERY IMPORTANT, DON'T SKIP IT! </h3>
            </header>
            <section class="modal-card-body">
                <p>This is your private key, write it down. You will need it when recovering your password, if you
                    forget it, you will not be able to restore access to your account.</p>
                <section class="hero is-danger">
                    <div class="hero-body">
                        <p class="title is-6">
                            Your secret:
                        </p>
                        <p class="subtitle">
                            {{ secret }}
                        </p>
                    </div>
                </section>
            </section>
            <footer class="modal-card-foot">
                <o-button :disabled="timeToModalClose > 0" variant="primary" @click="$emit('close', {action: 'yes'})">
                    {{ timeToModalClose <= 0 ? 'I memorized this key' : timeToModalClose }}
                </o-button>
            </footer>
        </div>
    </form>
</template>

<script>
export default {
    name: 'UserSecretModal',
    data() {
        return {
            timeToModalClose: 10
        }
    },
    props: ['secret'],
    mounted() {
        this.timeToModalClose = 10

        const countDown = setInterval(() => {
            if (this.timeToModalClose >= 1) {
                this.timeToModalClose--
            } else {
                clearInterval(countDown)
            }
        }, 1000)
    }
}
</script>

<style scoped>

</style>

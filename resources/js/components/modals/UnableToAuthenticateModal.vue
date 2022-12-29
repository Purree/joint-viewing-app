<template>
    <o-modal :can-cancel="false" v-model:active="isActive" :width="640" scroll="clip">
        <div class="modal-content is-flex is-flex-direction-column">
            <ErrorMessage :error-header="'Unable to determine user'"
                          :errors="{'error': ['Unable to sign in to your account, please try again later or sign out and sign in again.']}"/>
            <logout-button @click="this.$emit('update:isModalActive', false)"/>
        </div>
    </o-modal>
</template>

<script>
import ErrorMessage from '@/components/errors/ErrorMessage.vue'
import LogoutButton from '@/components/authentication/LogoutButton.vue'

export default {
    components: { LogoutButton, ErrorMessage },
    emits: ['update:isModalActive'],
    props: ['isModalActive'],
    data() {
        return {
            isActive: this.isModalActive || false
        }
    },
    name: 'UnableToAuthenticateModal'
}
</script>

<template>
    <error-message :errors="errors"></error-message>

    <settings-row property-name="Name">
        <o-input type="text" v-model="form.name"></o-input>
    </settings-row>
    <settings-row v-if="isCreating" property-name="Link">
        <o-input type="text" v-model="form.link"></o-input>
    </settings-row>
    <settings-row property-name="Does the room need a password?">
        <o-switch v-model="form.is_closed"></o-switch>
    </settings-row>
    <settings-row v-if="form.is_closed" property-name="Password">
        <o-input password-reveal type="password" v-model="form.password"></o-input>
    </settings-row>
    <settings-row property-name="Can everyone control video and add new videos?">
        <o-switch v-model="form.can_everyone_control"></o-switch>
    </settings-row>
    <settings-row property-name="Will the room be hidden in the rooms list?">
        <o-switch v-model="form.is_private"></o-switch>
    </settings-row>

    <submit-button class="is-fullwidth"
                   :is-loading="sendRequestPending"
                   :pending="sendRequestPending"
                   :text="sendRequestButtonText"
                   @click="$emit('updateRoom', form)"></submit-button>
</template>

<script>
import SubmitButton from '@/components/SubmitButton'
import ErrorMessage from '@/components/errors/ErrorMessage'
import SettingsRow from '@/components/settings/SettingsRow'

export default {
    name: 'RoomManipulateBlock',
    components: { SettingsRow, ErrorMessage, SubmitButton },
    emits: ['updateRoom'],
    data() {
        return {
            form: {
                name: this.roomData.name || '',
                link: this.roomData.link || '',
                is_closed: !!this.roomData.is_closed || false,
                password: this.roomData.password || '',
                can_everyone_control: !!this.roomData.can_everyone_control || false,
                is_private: !!this.roomData.is_private || false
            }
        }
    },
    props: {
        isCreating: {
            type: Boolean,
            default: false
        },
        roomData: {
            type: Object,
            default: () => ({})
        },
        sendRequestButtonText: {
            type: String,
            default: 'Update room'
        },
        sendRequestPending: {
            type: Boolean,
            default: false
        },
        errors: {
            type: Object,
            default: () => ({})
        }
    }
}
</script>

<style scoped>

</style>

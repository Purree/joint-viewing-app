<template>
    <o-skeleton :animated="true" v-if="pending" :width="'192px'" :height="'192px'"></o-skeleton>
    <div v-html="QRCodeSVG" v-if="!pending"></div>
</template>

<script>
import replaceDataInUri from "@/mixins/replaceDataInUri";
import {mapState} from "vuex";
import {API_TWO_FACTOR_GET_QR_CODE_URL} from "@/api/twoFactor";

export default {
    name: "QrCode",
    data() {
        return {
            QRCodeSVG: '',
            pending: true
        }
    },
    mounted() {
        axios.get(replaceDataInUri(API_TWO_FACTOR_GET_QR_CODE_URL, {'user': this.user.id})).then(response => {
            this.QRCodeSVG = response.data.svg
        }).catch(errors => {
            console.log(errors.response)
            this.QRCodeSVG = `<article class="message is-danger">
                <div class="message-header">
                    <p> Cannot load your QR. Try to recreate two-factor auth.</p>
                </div>
            </article>`
        }).then(() => {
            this.pending = false
        })
    },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>
    .b-skeleton {
        width: auto;
    }
</style>

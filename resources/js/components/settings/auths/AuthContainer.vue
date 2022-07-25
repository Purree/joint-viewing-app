<template>
    <div class="divider">{{ dividerText }}</div>

    <columns :columns="headerColumns"></columns>
    <div v-for="auth in auths" :key="auth.id">
        <hr/>
        <columns :columns="arrayKeys.map((el) => {
            if (typeof el === 'string')
                return auth[el]

            if (typeof el === 'object') {
                return el.action(auth[el.name])
            }
        })">
            <div class="column">
                <revoke-auth-button :deleting-auths="deletingAuths" @delete="deleteAuth" :auth-id="auth.id"/>
            </div>
        </columns>
    </div>
</template>

<script>
import RevokeAuthButton from "@/components/settings/auths/RevokeAuthButton.vue";
import Columns from "@/components/Columns.vue";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse.js";
import replaceDataInUri from "@/mixins/replaceDataInUri.js";
import {mapState} from "vuex";

export default {
    name: "AuthContainer",
    components: {Columns, RevokeAuthButton},
    emits: ['delete', 'update'],
    props: ['auths', 'deletingAuths', 'dividerText', 'headerColumns', 'arrayKeys', 'deleteRequestParams'],
    methods: {
        deleteAuth(id) {
            if (!this.deletingAuths.includes(id)) {
                this.deletingAuths.push(id);

                if (this.deleteRequestParams) {
                    axios.delete(
                        replaceDataInUri(
                            this.deleteRequestParams.uri,
                            {'userId': this.user.id, 'authId': id}
                        )
                    ).then((response) => {
                        if (response.data.logout) {
                            this.$store.dispatch('auth/logout');
                        }

                        this.$emit('update')
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
                        this.deletingAuths.splice(this.deletingAuths.indexOf(id), 1)
                    })
                } else {
                    this.$emit('delete', id)
                }

            }
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style scoped>

</style>

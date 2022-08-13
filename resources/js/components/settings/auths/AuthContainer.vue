<template>
    <divider>{{ dividerText }}</divider>

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
import errorsHelper from "@/mixins/errors.js";
import replaceDataInUri from "@/mixins/replaceDataInUri.js";
import {mapState} from "vuex";
import Divider from "@/components/Divider";

export default {
    name: "AuthContainer",
    components: {Columns, RevokeAuthButton, Divider},
    emits: ['delete', 'update'],
    props: ['auths', 'deletingAuths', 'dividerText', 'headerColumns', 'arrayKeys', 'deleteRequestParams'],
    methods: {
        deleteAuth(id) {
            if (this.deletingAuths.includes(id)) {
                return;
            }

            if (this.deleteRequestParams.uri) {
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
                    errorsHelper.methods.openResponseNotification(errors);
                }).then(() => {
                    this.deletingAuths.splice(this.deletingAuths.indexOf(id), 1)
                })
            } else {
                this.$emit('delete', id)
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

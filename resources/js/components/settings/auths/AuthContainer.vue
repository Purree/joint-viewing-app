<template>
    <divider>{{ dividerText }}</divider>

    <rows :columns="headerColumns"></rows>
    <div v-for="auth in auths" :key="auth.id">
        <hr/>
        <rows :columns="arrayKeys.map((el) => {
            if (typeof el === 'string')
                return auth[el]

            if (typeof el === 'object') {
                return el.action(auth[el.name])
            }
        })">
            <div class="column">
                <revoke-auth-button :deleting-auths="deletingAuths" @delete="deleteAuth" :auth-id="auth.id"/>
            </div>
        </rows>
    </div>
</template>

<script>
import RevokeAuthButton from '@/components/settings/auths/RevokeAuthButton.vue'
import Rows from '@/components/Rows.vue'
import errorsHelper from '@/mixins/errors.js'
import { mapState } from 'vuex'
import Divider from '@/components/Divider'
import apiRequest from '@/helpers/apiRequest'

export default {
    name: 'AuthContainer',
    components: {
        Rows,
        RevokeAuthButton,
        Divider
    },
    emits: ['delete', 'update', 'update:deletingAuths'],
    props: ['auths', 'deletingAuths', 'dividerText', 'headerColumns', 'arrayKeys', 'deleteRequestParams'],
    methods: {
        deleteAuth(id) {
            if (this.deletingAuths.includes(id)) {
                return
            }
            this.$emit('update:deletingAuths', this.deletingAuths.concat(id))

            if (this.deleteRequestParams.uri) {
                apiRequest(
                    this.deleteRequestParams.uri,
                    {
                        userId: this.user.id,
                        authId: id
                    }
                ).then((response) => {
                    if (response.data.logout) {
                        this.$store.dispatch('auth/logout')
                    }

                    this.$emit('update')
                }).catch(errors => {
                    errorsHelper.methods.openResponseNotification(errors)
                }).then(() => {
                    const indexOfDeletingAuth = this.deletingAuths.indexOf(id)
                    this.$emit('update:deletingAuths',
                        [
                            ...this.deletingAuths.slice(0, indexOfDeletingAuth),
                            ...this.deletingAuths.slice(indexOfDeletingAuth + 1)
                        ]
                    )
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

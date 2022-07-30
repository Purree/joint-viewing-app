<template>
    <divider>Avatar</divider>

    <ErrorMessage :errors="errors"></ErrorMessage>

    <div v-if="this.user.avatar" class="is-flex is-align-items-center is-flex-direction-column mb-3">
        <div>Current avatar</div>
        <file-image :file-url="asset(this.user.avatar)"></file-image>
        <submit-button class="mt-3"
                       variant="danger"
                       @click="usePending(deleteAvatar, 'avatarDeletePending')"
                       :is-loading="avatarDeletePending"
                       :pending="avatarDeletePending"
                       :text="'Delete avatar'"></submit-button>
    </div>

    <section>
        <div class="file is-boxed is-justify-content-center mb-2">
            <o-upload accept="image/*" rootClass="file-label" class="file-input" v-model="uploadedFile" dragDrop
                      draggableClass="upload-draggable">
                <span class="file-cta">
                    <span class="file-icon">
                        <o-icon icon="upload" size="is-large"></o-icon>
                    </span>
                    <span class="file-label">
                         Choose a file…
                    </span>
                </span>
            </o-upload>
        </div>

        <div class="tags is-align-items-center is-flex-direction-column" v-if="uploadedFile.size !== 0">
            <div>Chosen file</div>
            <file-image :file-url="getFileUrl(this.uploadedFile)"></file-image>
            <o-button icon-left="times" size="small" native-type="button" @click="deleteDropFile"></o-button>
            <submit-button class="mt-3"
                           :variant="'basic'"
                           :pending="avatarUploadPending"
                           :text="'Change avatar'"
                           :is-loading="avatarUploadPending"
                           @click="usePending(updateAvatar, 'avatarUploadPending')"/>
        </div>

    </section>
</template>

<script>
import {mapState} from "vuex";
import FileImage from "@/components/FileImage.vue";
import asset from "@/mixins/asset.js";
import SubmitButton from "@/components/SubmitButton.vue";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse.js";
import usePending from "@/mixins/usePending.js";
import {API_DELETE_AVATAR_URL, API_UPDATE_AVATAR_URL} from "@/api/users.js";
import replaceDataInUri from "@/mixins/replaceDataInUri.js";
import ErrorMessage from "@/components/errors/ErrorMessage.vue";
import Divider from "@/components/Divider";

export default {
    name: "AvatarSettingsBlock",
    components: {SubmitButton, FileImage, ErrorMessage, Divider},
    mixins: [asset, getErrorsFromResponse, usePending, replaceDataInUri],
    data() {
        return {
            uploadedFile: new File([], ""),
            avatarUploadPending: false,
            avatarDeletePending: false,
            errors: {}
        }
    },
    methods: {
        getFileUrl(file) {
            return URL.createObjectURL(file)
        },
        deleteDropFile() {
            this.uploadedFile = new File([], "")
        },
        deleteAvatar() {
            return axios.delete(replaceDataInUri(API_DELETE_AVATAR_URL, {'id': this.user.id})).then(() => {
                this.errors = {}
                this.user.avatar = null
            }).catch(error => {
                this.errors = getErrorsFromResponse(error)
            })
        },
        updateAvatar() {
            if (this.uploadedFile.size / 1024 === 0) {
                this.errors = {
                    avatar: ["Please choose a file"]
                }
                return
            }

            if (this.uploadedFile.size / 1024 > 2048) {
                this.errors = {
                    avatar: ["File is too big"]
                }
                return
            }

            let formData = new FormData();
            formData.append("photo", this.uploadedFile);

            return axios.post(replaceDataInUri(API_UPDATE_AVATAR_URL, {'id': this.user.id}),
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response) => {
                    this.user.avatar = response.data.avatarPath;
                    this.errors = {}
                }).catch(errors => {
                    console.log(errors);
                    this.errors = getErrorsFromResponse(errors);
                })
        },
    },
    computed: {
        ...mapState('auth', ['user']),
    }
}
</script>

<style>
.upload-draggable {
    border-width: 0 !important;
}
</style>

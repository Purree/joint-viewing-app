<template>
    <div class="divider is-unselectable">Avatar</div>

    <ErrorMessage :errors="errors"></ErrorMessage>

    <div v-if="currentAvatar" class="is-flex is-align-items-center is-flex-direction-column">
        <div>Current avatar</div>
        <file-image :file-url="asset(currentAvatar)"></file-image>
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
                           :pending="avatarPending"
                           :text="'Change avatar'"
                           :is-loading="avatarPending"
                           @click="usePending(updateAvatar)"/>
        </div>

    </section>
</template>

<script>
import {mapState} from "vuex";
import FileImage from "@/components/FileImage";
import asset from "@/mixins/asset";
import SubmitButton from "@/components/SubmitButton";
import getErrorsFromResponse from "@/mixins/getErrorsFromResponse";
import usePending from "@/mixins/usePending";
import {API_UPDATE_AVATAR_URL} from "@/api/users";
import replaceDataInUri from "@/mixins/replaceDataInUri";
import ErrorMessage from "@/components/errors/ErrorMessage";

export default {
    name: "AvatarSettingsBlock",
    components: {SubmitButton, FileImage, ErrorMessage},
    mixins: [asset, getErrorsFromResponse, usePending, replaceDataInUri],
    data() {
        return {
            uploadedFile: new File([], ""),
            avatarPending: false,
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
                    this.currentAvatar = response.data.avatarPath;
                    this.errors = {}
                }).catch(errors => {
                    console.log(errors);
                    this.errors = getErrorsFromResponse(errors);
                })
        },
    },
    computed: {
        ...mapState('auth', ['user']),
        currentAvatar: {
            get() {
                return this.user.avatar
            },
            set(value) {
                this.user.avatar = value
            }
        }
    }
}
</script>

<style>
.upload-draggable {
    border-width: 0 !important;
}
</style>

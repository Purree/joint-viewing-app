<template>
    <div class="divider is-unselectable">Avatar</div>

    <div v-if="currentAvatar" class="is-flex is-align-items-center is-flex-direction-column">
        <div>Current avatar</div>
        <file-image :file-url="asset(currentAvatar)"></file-image>
    </div>

    <section>
        <div class="file is-boxed is-justify-content-center mb-2">
            <o-upload accept="image/*" rootClass="file-label" class="file-input" v-model="dropFile" dragDrop
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

        <div class="tags is-align-items-center is-flex-direction-column" v-if="dropFile.size !== 0">
            <div>Chosen file</div>
            <file-image :file-url="getFileUrl()"></file-image>
            <o-button icon-left="times" size="small" native-type="button" @click="deleteDropFile"></o-button>
            <submit-button class="mt-3"
                           :variant="'basic'"
                           :pending="avatarPending"
                           :text="'Change avatar'"
                           :is-loading="avatarPending"
            ></submit-button>
        </div>

    </section>
</template>

<script>
import {mapState} from "vuex";
import FileImage from "@/components/FileImage";
import asset from "@/mixins/asset";
import SubmitButton from "@/components/SubmitButton";

export default {
    name: "AvatarSettingsBlock",
    components: {SubmitButton, FileImage},
    mixins: [asset],
    data() {
        return {
            dropFile: new File([], ""),
            currentAvatar: this.user?.avatar,
            avatarPending: false,
        }
    },
    methods: {
        getFileUrl() {
            return URL.createObjectURL(this.dropFile)
        },
        deleteDropFile() {
            this.dropFile = new File([], "")
        }
    },
    computed: {
        ...mapState('auth', ['user'])
    }
}
</script>

<style>
.upload-draggable {
    border-width: 0 !important;
}
</style>

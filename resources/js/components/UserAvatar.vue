<template>
    <div class="user-avatar"
         :style="`background-image: url(${ asset(avatarPath || 'profile-photos/default.png') });
                  width: ${size || '40px'};
                  height: ${size || '40px'};`"></div>
</template>

<script>
import asset from "@/mixins/asset";

export default {
    name: "UserAvatar",
    mixins: [asset],
    props: {
        avatarPath: {
            type: String,
            required: false
        },
        size: {
            type: String,
            required: false
        },
    },
}
</script>

<style scoped>
.user-avatar {
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>

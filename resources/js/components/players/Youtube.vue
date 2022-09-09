<template>
    <div class="h-100 w-100" id="ytplayer"></div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "Youtube",
    props: {
        videoId: {
            type: String,
            required: true,
        },
        canControl: {
            type: Boolean,
            required: true,
        }
    },
    mounted() {
        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        window.onYouTubePlayerAPIReady = () => {
            this.$store.commit('player/setPlayer', new YT.Player('ytplayer', {
                height: '100%',
                width: '100%',
                videoId: this.videoId,
                events: {
                    'onReady': (e) => {console.log(e)},
                    'onStateChange': (e) => {console.log(e);}
                },
                playerVars: {
                    'autoplay': 0,
                    'showinfo': 0,
                    'rel': 0,
                    'color': 'white'
                },
            }));
        }
    },
    watch: {
        videoId() {
            this.player.loadVideoById(this.videoId);
        }
    },
    computed: {
        ...mapState('player', ['player']),
    }
}
</script>

<style scoped>

</style>

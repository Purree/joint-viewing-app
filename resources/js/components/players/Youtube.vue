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
        },
        isHost: {
            type: Boolean,
            required: true,
        }
    },
    emits: ['playerReady', 'synchronize', 'requestSynchronization', 'videoEnded'],
    methods: {
        onPlayerReady(event) {
            this.$emit('playerReady')
        },
        onPlayerStateChange(event) {
            if (event.data === 0) {
                this.$emit('videoEnded')
            }
            if (event.data === 1 || event.data === 2) {
                if (!this.canControl) {
                    this.player.pauseVideo();
                }

                this.$emit(this.canControl || this.isHost ? 'synchronize' : 'requestSynchronization')
            }
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
                    'onReady': this.onPlayerReady,
                    'onStateChange': this.onPlayerStateChange,
                    'onPlaybackQualityChange': this.onPlayerStateChange,
                    'onPlaybackRateChange': this.onPlayerStateChange,
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

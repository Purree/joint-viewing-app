<template>
    <div class="h-100 w-100" id="ytplayer"></div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "Youtube",
    data() {
        return {
            'lastTime': 0,
        }
    },
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
        },
        skipNextEvent: {
            type: Boolean,
            required: true,
        },
        lastSynchronizationData: {
            type: Object,
            required: true,
        },
    },
    emits: ['playerReady', 'synchronize', 'requestSynchronization', 'videoEnded', 'ignoreNextEvent', 'listenNextEvent'],
    methods: {
        onPlayerReady(event) {
            this.addVideoSeekListener()
            this.$emit('playerReady')
        },
        onPlayerStateChange(event) {
            if (this.skipNextEvent) {
                this.$emit('listenNextEvent')
                return
            }

            if (event.data === 0) {
                this.$emit('videoEnded')
            }
            if (event.data === 1 || event.data === 2) {
                if (!this.canControl && this.player.getPlayerState() !== 2 && !!this.lastSynchronizationData?.is_paused) {
                    this.$emit('ignoreNextEvent')
                    this.player.pauseVideo()
                }

                this.$emit(this.canControl || this.isHost ? 'synchronize' : 'requestSynchronization')
            }
        },
        addVideoSeekListener() {
            setInterval(() => {
                if (this.lastTime !== 0 && Math.abs(this.player.getCurrentTime() - this.lastTime - 1 * this.player.getPlaybackRate()) > 1.5) {
                    this.$emit(this.canControl || this.isHost ? 'synchronize' : 'requestSynchronization')
                }
                this.lastTime = this.player.getCurrentTime()
            }, 1000)
        },
    },
    mounted() {
        if (!document.querySelector('script[src="https://www.youtube.com/player_api"]')) {
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
        }
    },
    unmounted() {
        document.querySelector('script[src="https://www.youtube.com/player_api"]').remove()
        this.$store.commit('player/setPlayer', null)
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

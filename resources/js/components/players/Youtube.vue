<template>
    <div class="h-100 w-100" id="ytplayer"></div>
</template>

<script>
import { mapState } from 'vuex'
import errorsHelper from '@/mixins/errors'

export default {
    name: 'Youtube',
    data() {
        return {
            lastTime: 0,
            synchronizationInterval: null,
            lastSynchronizationData: {}
        }
    },
    props: {
        videoUrl: {
            type: String,
            required: true
        },
        canControl: {
            type: Boolean,
            required: true
        },
        isHost: {
            type: Boolean,
            required: true
        },
        skipNextEvent: {
            type: Boolean,
            required: true
        }
    },
    emits: ['playerReady', 'synchronize', 'requestSynchronization', 'videoEnded', 'ignoreNextEvent', 'listenNextEvent'],
    methods: {
        synchronize(time, is_paused, playback_rate, synchronizer_timestamp, additional_data = {}) {
            this.$emit('ignoreNextEvent')

            this.lastSynchronizationData = {
                time,
                is_paused,
                playback_rate,
                synchronizer_timestamp,
                synchronizationTime: new Date().getTime(),
                synchronizationAttemptPerMinute:
                    new Date().getMinutes() === new Date(this.lastSynchronizationData.synchronizationTime).getMinutes()
                        ? ++this.lastSynchronizationData.synchronizationAttemptPerMinute
                        : 1
            }

            const timeWithUncertainty = is_paused ? time : time + (new Date().getTime() - synchronizer_timestamp) / 1000 * playback_rate

            if (this.lastSynchronizationData.synchronizationAttemptPerMinute > 30) {
                errorsHelper.methods.openNotification('It looks like your player is syncing too often. Perhaps you or your leader has a video playback speed that is different from the speed set in the player, check this, if this does not help, then try to reduce the number of actions with the player. If so many requests come from you, we will be forced to block you for a short time.')
            }

            if (additional_data.playlistIndex !== null &&
                additional_data.playlistIndex !== undefined &&
                this.player.getPlaylistIndex() !== additional_data.playlistIndex) {
                this.loadPlaylist(this.parsePlaylistLink(this.videoUrl), additional_data.playlistIndex, timeWithUncertainty)
            }

            if (this.player.getCurrentTime() < timeWithUncertainty - 3 || timeWithUncertainty + 3 < this.player.getCurrentTime()) {
                this.player.seekTo(timeWithUncertainty, true)
            }

            if (is_paused) {
                if (this.player.getPlayerState() !== 2) {
                    this.player.seekTo(time, true)
                    this.player.pauseVideo()
                }
            } else {
                if (this.player.getPlayerState() !== 1) {
                    this.player.seekTo(timeWithUncertainty, true)
                    this.player.playVideo()
                }
            }

            if (this.player.getPlaybackRate() !== playback_rate) {
                this.player.setPlaybackRate(playback_rate)
            }
        },
        loadPlaylist(listId, index = 0, startSeconds = 0) {
            this.player.loadPlaylist({
                list: listId,
                listType: 'playlist',
                index,
                startSeconds,
                suggestedQuality: 'default'
            })
        },
        sendSynchronizationEvent() {
            const synchronizationParameters =
                this.player.getPlaylistIndex() !== null && this.player.getPlaylistIndex() !== undefined
                    ? {
                        additional_data: {
                            playlistIndex: this.player.getPlaylistIndex()
                        }
                    }
                    : {}

            if (this.canControl || this.isHost) {
                this.$emit('synchronize', synchronizationParameters)
            } else {
                this.$emit('requestSynchronization')
            }
        },
        onPlayerReady(event) {
            this.addVideoSeekListener()
            this.addCheckForVideoChangeListener()
            this.$emit('playerReady')
        },
        onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.ENDED) {
                this.$emit('videoEnded')
            }
            if (event.data === YT.PlayerState.PLAYING || event.data === YT.PlayerState.PAUSED) {
                if (!this.canControl && this.player.getPlayerState() !== YT.PlayerState.PAUSED && !!this.lastSynchronizationData?.is_paused) {
                    this.player.pauseVideo()
                }

                if (this.skipNextEvent && !this.isHost && !this.canControl) {
                    this.$emit('listenNextEvent')
                } else {
                    this.$emit('ignoreNextEvent')
                    this.sendSynchronizationEvent()
                }
            }
        },
        addVideoSeekListener() {
            this.synchronizationInterval = setInterval(() => {
                if (this.lastTime !== 0 && Math.abs(this.player.getCurrentTime() - this.lastTime - (this.player.getPlayerState() !== YT.PlayerState.PLAYING * this.player.getPlaybackRate())) > 1.5) {
                    this.sendSynchronizationEvent()
                }
                this.lastTime = this.player.getCurrentTime()
            }, 1000)
        },
        addCheckForVideoChangeListener() {
            setInterval(() => {
                this.sendSynchronizationEvent()
            }, 30000)
        },
        parseVideoLink(url) {
            const regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/
            const match = url.match(regExp)
            return match[2] || ''
        },
        parsePlaylistLink(url) {
            return new URL(url).searchParams.get('list')
        }
    },
    beforeCreate() {
        if (window.onYouTubePlayerAPIReady) {
            location.reload()
        }
    },
    mounted() {
        if (!document.querySelector('script[src="https://www.youtube.com/player_api"]')) {
            const tag = document.createElement('script')
            tag.src = 'https://www.youtube.com/player_api'
            const firstScriptTag = document.getElementsByTagName('script')[0]
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag)

            window.onYouTubePlayerAPIReady = () => {
                this.$store.commit('player/setPlayer', new YT.Player('ytplayer', {
                    height: '100%',
                    width: '100%',
                    videoId: this.parseVideoLink(this.videoUrl),
                    events: {
                        onReady: this.onPlayerReady,
                        onStateChange: this.onPlayerStateChange,
                        onPlaybackQualityChange: this.sendSynchronizationEvent,
                        onPlaybackRateChange: this.sendSynchronizationEvent
                    },
                    playerVars: {
                        showinfo: 0,
                        rel: 0,
                        color: 'white',
                        list: this.parsePlaylistLink(this.videoUrl)
                    }
                }))
                this.$emit('requestSynchronization')
            }
        }
    },
    beforeUnmount() {
        clearInterval(this.synchronizationInterval)
        this.player.destroy()
        document.querySelector('script[src="https://www.youtube.com/player_api"]').remove()
        document.querySelector('script#www-widgetapi-script').remove()
        this.$store.commit('player/setPlayer', null)
    },
    watch: {
        videoUrl() {
            this.player.stopVideo()
            this.player.clearVideo()

            const playlistId = this.parsePlaylistLink(this.videoUrl)

            if (playlistId) {
                this.loadPlaylist(playlistId)
            } else {
                this.player.loadVideoById(this.parseVideoLink(this.videoUrl))
            }
        }
    },
    computed: {
        ...mapState('player', ['player'])
    }
}
</script>

<style scoped>

</style>

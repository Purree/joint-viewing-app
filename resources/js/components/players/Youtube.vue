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
            lastSynchronizationData: {},
            synchronizationPending: false
        }
    },
    props: {
        cachedSynchronizationParameters: {
            type: Object,
            required: true
        },
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
        }
    },
    emits: [
        'playerReady',
        'synchronize',
        'requestSynchronization',
        'videoEnded',
        'ignoreNextEvent',
        'listenNextEvent',
        'update:cachedSynchronizationParameters'
    ],
    methods: {
        synchronize(time, isPaused, playbackRate, synchronizerTimestamp, additionalData = {}) {
            this.synchronizationPending = true

            this.lastSynchronizationData = {
                time,
                isPaused,
                playbackRate,
                synchronizerTimestamp,
                synchronizationTime: new Date().getTime(),
                synchronizationAttemptPerMinute:
                    new Date().getMinutes() === new Date(this.lastSynchronizationData.synchronizationTime).getMinutes()
                        ? ++this.lastSynchronizationData.synchronizationAttemptPerMinute
                        : 1
            }

            const timeWithUncertainty = isPaused ? time : time + (new Date().getTime() - synchronizerTimestamp) / 1000 * playbackRate

            if (this.lastSynchronizationData.synchronizationAttemptPerMinute > 60 && !this.isHost) {
                errorsHelper.methods.openNotification('It looks like your player is syncing too often. Perhaps you or your leader has a video playback speed that is different from the speed set in the player, check this, if this does not help, then try to reduce the number of actions with the player. If so many requests come from you, we will be forced to block you for a short time.')
            }

            if (additionalData.playlistIndex !== null &&
                additionalData.playlistIndex !== undefined &&
                this.player.getPlaylistIndex() !== additionalData.playlistIndex) {
                this.loadPlaylist(this.parsePlaylistLink(this.videoUrl), additionalData.playlistIndex, timeWithUncertainty)
            }

            if (this.player.getCurrentTime() < timeWithUncertainty - 3 || timeWithUncertainty + 3 < this.player.getCurrentTime()) {
                this.player.seekTo(timeWithUncertainty, true)
            }

            if (isPaused) {
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

            if (this.player.getPlaybackRate() !== playbackRate) {
                this.player.setPlaybackRate(playbackRate)
            }

            this.synchronizationPending = false
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
            if (this.synchronizationPending) {
                return
            }

            const synchronizationParameters =
                this.player.getPlaylistIndex() !== null && this.player.getPlaylistIndex() !== undefined
                    ? {
                        additionalData: {
                            playlistIndex: this.player.getPlaylistIndex()
                        }
                    }
                    : {}

            this.$emit('update:cachedSynchronizationParameters', synchronizationParameters)

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
            if (this.synchronizationPending) {
                return
            }

            if (event.data === window.YT.PlayerState.ENDED) {
                this.$emit('videoEnded')
            }
            if (event.data === window.YT.PlayerState.PLAYING || event.data === window.YT.PlayerState.PAUSED) {
                if (!this.canControl && this.player.getPlayerState() !== window.YT.PlayerState.PAUSED && !!this.lastSynchronizationData?.isPaused) {
                    this.player.pauseVideo()
                }

                this.sendSynchronizationEvent()
            }
        },
        addVideoSeekListener() {
            this.synchronizationInterval = setInterval(() => {
                // If a player's time has been changed
                if (
                    this.lastTime !== 0 &&
                    Math.abs(
                        this.player.getCurrentTime() - this.lastTime - (
                            this.player.getPlayerState() !==
                            window.YT.PlayerState.PLAYING * this.player.getPlaybackRate()
                        )
                    ) > 1.5
                ) {
                    this.synchronizationPending = true
                    this.player.pauseVideo()
                    this.sendSynchronizationEvent()
                    this.synchronizationPending = false
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
                this.$store.commit('player/setPlayer', new window.YT.Player('ytplayer', {
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

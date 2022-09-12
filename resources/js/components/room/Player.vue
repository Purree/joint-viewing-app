<template>
    <div class="h-100 w-100">
        <youtube :is-host="host === user.id"
                 ref="player"
                 @player-ready="onPlayerReady"
                 @synchronize="synchronizeClients()"
                 @request-synchronization="requestSynchronization()"
                 @ignore-next-event="this.skipNextEvent = true"
                 @listen-next-event="this.skipNextEvent = false"
                 :video-id="videoId"
                 :can-control="canControl"
                 :last-synchronization-data="lastSynchronizationData"
                 :skip-next-event="skipNextEvent"></youtube>
    </div>
</template>

<script>
import Youtube from "@/components/players/Youtube";
import apiRequest from "@/helpers/apiRequest";
import {API_REQUEST_SYNCHRONIZATION_URL, API_SYNCHRONIZATION_URL} from "@/api/synchronization";
import broadcastConnections from "@/mixins/broadcastConnections";
import {mapState} from "vuex";

export default {
    name: "Player",
    components: {Youtube},
    data() {
        return {
            skipNextEvent: false,
            lastSynchronizationData: {},
        }
    },
    props: {
        room: {
            type: Object,
            required: true
        },
        canControl: {
            type: Boolean,
            required: true,
        },
        videoId: {
            type: String,
            required: true,
        },
        host: {
            type: Number,
            required: true,
        },
    },
    methods: {
        requestSynchronization() {
            return apiRequest(API_REQUEST_SYNCHRONIZATION_URL, {'roomId': this.room.id})
        },
        synchronizeClients(time = this.player.getCurrentTime(), player_state = this.player.getPlayerState(), playback_rate = this.player.getPlaybackRate()) {
            return apiRequest(API_SYNCHRONIZATION_URL, {'roomId': this.room.id}, {
                'time': time,
                'is_paused': [-1, 0, 2, 5].includes(player_state),
                'playback_rate': playback_rate
            })
        },
        synchronize(time, is_paused, playback_rate) {
            this.lastSynchronizationData = {
                'time': time,
                'is_paused': is_paused,
                'playback_rate': playback_rate
            }

            if (this.player.getCurrentTime() < time - 3 || time + 3 > this.player.getCurrentTime()) {
                this.skipNextEvent = true;
                this.player.seekTo(time, true);
            }

            if (is_paused) {
                if (this.player.getPlayerState() !== 2) {
                    this.skipNextEvent = true;
                    this.player.pauseVideo();
                }
            } else {
                if (this.player.getPlayerState() !== 1) {
                    this.skipNextEvent = true;
                    this.player.playVideo();
                }
            }

            if (this.player.getPlaybackRate() !== playback_rate) {
                this.skipNextEvent = true;
                this.player.setPlaybackRate(playback_rate);
            }
        },
        onPlayerReady() {
            broadcastConnections.methods.connectToRoom(this.room.id)
                .listen('PlayerSynchronizeRequest', () => {
                    if (this.host === this.user.id) {
                        this.synchronizeClients()
                    }
                })
                .listen('PlayerSynchronize', (response) => {
                    if (this.host !== this.user.id) {
                        this.synchronize(response.time, response.is_paused, response.playback_rate)
                    }
                })
        },
    },
    computed: {
        ...mapState('auth', ['user']),
        ...mapState('player', ['player']),
    },
}
</script>

<style scoped>

</style>

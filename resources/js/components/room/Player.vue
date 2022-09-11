<template>
    <div class="h-100 w-100">
        <youtube ref="player" @player-ready="onPlayerReady" :video-id="videoId" :can-control="canControl"></youtube>
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
        }
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
            if (this.player.getCurrentTime() < time - 3 || time + 3 > this.player.getCurrentTime()) {
                this.player.seekTo(time, true);
            }
            if (is_paused) {
                this.player.pauseVideo();
            } else {
                this.player.playVideo();
            }

            this.player.setPlaybackRate(playback_rate);
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

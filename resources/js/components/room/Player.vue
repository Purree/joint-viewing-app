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
            apiRequest(API_REQUEST_SYNCHRONIZATION_URL, {'roomId': this.room.id})
        },
        synchronizeClients(time, is_paused, playback_rate) {
            apiRequest(API_SYNCHRONIZATION_URL, {'roomId': this.room.id}, {
                'time': time,
                'is_paused': is_paused,
                'playback_rate': playback_rate
            })
        },
        onPlayerReady() {
            broadcastConnections.methods.connectToRoom(this.room.id)
                .listen('PlayerSynchronizeRequest', () => {
                    if (this.host === this.user.id) {
                        this.synchronizeClients(this.player.getCurrentTime(), this.player.getPlayerState(), this.player.getPlaybackRate())
                    }
                });
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

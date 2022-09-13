<template>
    <div class="h-100 w-100">
        <div v-if="synchronizationPending" class="is-absolute synchronization">
            <section class="hero is-success">
                <div class="hero-body">
                    <o-loading overlayClass="is-transparent" :full-page="false" :active="true"
                               :can-cancel="false"></o-loading>
                </div>
            </section>
        </div>
        <youtube :is-host="host === user.id"
                 ref="player"
                 @player-ready="onPlayerReady"
                 @synchronize="usePending(synchronizeClients, 'synchronizationPending')"
                 @request-synchronization="usePending(requestSynchronization, 'synchronizationPending')"
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
import usePending from "@/mixins/usePending";

export default {
    name: "Player",
    components: {Youtube},
    mixins: [usePending],
    data() {
        return {
            skipNextEvent: false,
            lastSynchronizationData: {},
            synchronizationPending: false,
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
                        this.synchronizationPending = true;
                        this.synchronizeClients().then(() => {
                            this.synchronizationPending = false;
                        })
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
    .synchronization {
        z-index: 1;
        left: 50%;
        transform: translate(-50%);
    }
</style>

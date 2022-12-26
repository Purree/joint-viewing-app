<template>
    <div class="h-100 w-100">
        <div class="h-100 w-100" v-if="!!videoId">
            <div v-if="synchronizationPending || synchronizationErrorPending" class="is-absolute synchronization">
                <section class="hero" :class="synchronizationErrorPending ? 'is-danger' : 'is-success'">
                    <div class="hero-body">
                        <o-loading :icon="synchronizationErrorPending ? 'xmark': 'spinner'"
                                   :iconSpin="!synchronizationErrorPending"
                                   overlayClass="is-transparent"
                                   :full-page="false"
                                   :active="true"
                                   :can-cancel="false"></o-loading>
                    </div>
                </section>
            </div>
            <youtube :is-host="host === user.id"
                     ref="player"
                     @player-ready="onPlayerReady"
                     @synchronize="sendSynchronizationToClients"
                     @request-synchronization="usePending(requestSynchronization, 'synchronizationPending')"
                     @ignore-next-event="this.skipNextEvent = true"
                     @listen-next-event="this.skipNextEvent = false"
                     :video-url="videoId"
                     :can-control="canControl"
                     :skip-next-event="this.skipNextEvent"></youtube>
        </div>
        <div class="h-100 w-100 is-flex is-justify-content-center is-align-items-center" v-else>
            <div class="has-text-centered">
                Empty video.
            </div>
        </div>
    </div>
</template>

<script>
import Youtube from "@/components/players/Youtube";
import apiRequest from "@/helpers/apiRequest";
import {API_REQUEST_SYNCHRONIZATION_URL, API_SYNCHRONIZATION_URL} from "@/api/synchronization";
import broadcastConnections from "@/mixins/broadcastConnections";
import {mapState} from "vuex";
import usePending from "@/mixins/usePending";
import errorsHelper from "@/mixins/errors";

export default {
    name: "Player",
    components: {Youtube},
    mixins: [usePending],
    data() {
        return {
            skipNextEventPending: false,
            synchronizationPending: false,
            synchronizationErrorText: '',
            synchronizationErrorPending: false,
            skipNextEventTimeout: null,
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
        async sendSynchronizationToClients(...parameters) {
            await usePending.methods.usePending(this.synchronizeClients, 'synchronizationPending', ...parameters)
        },
        requestSynchronization() {
            return apiRequest(API_REQUEST_SYNCHRONIZATION_URL, {'roomId': this.room.id})
                .catch((error) => {
                    errorsHelper.methods.openResponseNotification(error);
                    this.synchronizationError = errorsHelper.methods.getFromResponse(error);
                })
        },
        synchronizeClients(
            {
                time = this.player.getCurrentTime(),
                player_state = this.player.getPlayerState(),
                playback_rate = this.player.getPlaybackRate(),
                timestamp = new Date().getTime(),
                additional_data = {}
            }
        ) {
            return apiRequest(API_SYNCHRONIZATION_URL, {'roomId': this.room.id}, {
                'time': time,
                'is_paused': [-1, 0, 2, 5].includes(player_state),
                'playback_rate': playback_rate,
                'synchronizer_timestamp': timestamp,
                'additional_data': additional_data
            })
                .catch((error) => {
                    errorsHelper.methods.openResponseNotification(error);
                    this.synchronizationError = errorsHelper.methods.getFromResponse(error);
                })
        },
        synchronize(time, is_paused, playback_rate, synchronizer_timestamp, additional_data = {}) {
            this.$refs.player.synchronize(time, is_paused, playback_rate, synchronizer_timestamp, additional_data)
        },
        onPlayerReady() {
            broadcastConnections.methods.connectToRoom(this.room.id)
                .listen('PlayerSynchronizeRequest', () => {
                    if (this.host === this.user.id) {
                        this.synchronizationPending = true;
                        this.synchronizeClients({}).then(() => {
                            this.synchronizationPending = false;
                        })
                    }
                })
                .listen('PlayerSynchronize', (response) => {
                    if (response.synchronizer_id !== this.user.id) {
                        this.synchronize(
                            response.time,
                            response.is_paused,
                            response.playback_rate,
                            response.synchronizer_timestamp,
                            response.additional_data ?? {}
                        )
                    }
                })
        },
    },
    computed: {
        ...mapState('auth', ['user']),
        ...mapState('player', ['player']),
        synchronizationError: {
            get: function () {
                return this.synchronizationErrorText;
            },
            set: function (error = '') {
                this.synchronizationErrorText = error;

                if (error !== '') {
                    this.synchronizationErrorPending = true;

                    setTimeout(() => {
                        this.synchronizationErrorPending = false;
                    }, 1000)
                }
            }
        },
        skipNextEvent: {
            get: function () {
                return this.skipNextEventPending;
            },
            set: function (value) {
                clearTimeout(this.skipNextEventTimeout);
                this.skipNextEventPending = value;

                this.skipNextEventTimeout = setTimeout(() => {
                    this.skipNextEventPending = false;
                }, 5000)
            }
        },
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

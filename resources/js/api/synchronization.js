import { API } from '@/api/api_prefixes.js'

export const API_SYNCHRONIZATION_URL = ['post', API + 'rooms/{roomId}/player/host/synchronize']
export const API_REQUEST_SYNCHRONIZATION_URL = ['post', API + 'rooms/{roomId}/player/client/synchronize']

import {API} from "@/api/api_prefixes.js"

export const API_SHOW_ALL_SESSIONS_URL = API + 'users/{id}/sessions'
export const API_DELETE_ALL_SESSIONS_URL = API + 'users/{id}/sessions'
export const API_DELETE_SESSIONS_URL = API + 'users/{userId}/sessions/{authId}'

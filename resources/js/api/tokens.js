import {API} from "@/api/api_prefixes"

export const API_SHOW_ALL_TOKENS_URL = API + 'users/{id}/tokens'
export const API_DELETE_ALL_TOKENS_URL = API + 'users/{id}/tokens'
export const API_DELETE_TOKEN_URL = API + 'users/{userId}/tokens/{authId}'

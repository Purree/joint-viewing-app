import { API } from '@/api/api_prefixes.js'

export const API_SHOW_ALL_TOKENS_URL = ['get', API + 'users/{id}/tokens']
export const API_DELETE_ALL_TOKENS_URL = ['delete', API + 'users/{id}/tokens']
export const API_DELETE_TOKEN_URL = ['delete', API + 'users/{userId}/tokens/{authId}']

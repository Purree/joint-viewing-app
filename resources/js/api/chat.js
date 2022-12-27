import { API } from '@/api/api_prefixes.js'

export const API_GET_ALL_MESSAGES_URL = ['get', API + 'rooms/{roomId}/chat/messages']
export const API_SEND_MESSAGE_URL = ['post', API + 'rooms/{roomId}/chat/messages']

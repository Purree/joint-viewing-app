import { API } from '@/api/api_prefixes.js'

export const API_GET_ALL_ORDERS_URL = ['get', API + 'rooms/{roomId}/orders']
export const API_ADD_ORDER_URL = ['post', API + 'rooms/{roomId}/orders']
export const API_DELETE_ORDER_URL = ['delete', API + 'rooms/{roomId}/orders/{orderId}']

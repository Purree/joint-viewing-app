import {API} from "@/api/api_prefixes.js"

export const API_GET_ALL_ORDERS_URL = API + 'rooms/{roomId}/orders';
export const API_ADD_ORDER_URL = API + 'rooms/{roomId}/orders';
export const API_DELETE_ORDER_URL = API + 'rooms/{roomId}/orders/{orderId}';

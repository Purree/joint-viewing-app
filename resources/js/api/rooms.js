import {API} from "@/api/api_prefixes.js";

export const API_ALL_ROOMS_URL = API + 'rooms';
export const API_CREATE_ROOM_URL = API + 'rooms';
export const API_UPDATE_ROOM_URL = API + 'rooms/{roomId}';
export const API_JOIN_ROOM_URL = API + 'rooms/{roomId}/join';
export const API_LEAVE_ROOM_URL = API + 'rooms/{roomId}/leave';
export const API_GET_ROOM_DATA_URL = API + 'rooms/{roomId}';
export const API_GET_ROOM_DATA_BY_LINK_URL = API + 'rooms/link/{roomLink}';
export const API_KICK_USER_URL = API + 'rooms/{roomId}/kick/{userId}';

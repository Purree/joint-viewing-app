import {API} from "@/api/api_prefixes.js";

export const API_ALL_ROOMS_URL = ['get', API + 'rooms'];
export const API_CREATE_ROOM_URL = ['post', API + 'rooms'];
export const API_UPDATE_ROOM_URL = ['put', API + 'rooms/{roomId}'];
export const API_JOIN_ROOM_URL = ['post', API + 'rooms/{roomId}/join'];
export const API_LEAVE_ROOM_URL = ['post', API + 'rooms/{roomId}/leave'];
export const API_GET_ROOM_DATA_URL = ['get', API + 'rooms/{roomId}'];
export const API_GET_ROOM_DATA_BY_LINK_URL = ['get', API + 'rooms/link/{roomLink}'];
export const API_GET_ALL_MEMBERS_URL = ['get', API + 'rooms/{roomId}/members'];
export const API_KICK_MEMBER_URL = ['delete', API + 'rooms/{roomId}/members/{userId}'];

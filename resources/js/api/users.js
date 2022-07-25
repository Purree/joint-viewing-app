import {API} from "@/api/api_prefixes.js"

export const API_CURRENT_USER_URL = API + 'users/me';
export const API_CHANGE_NICKNAME_URL = API + 'users/{id}/name';
export const API_CHANGE_PASSWORD_URL = API + 'users/{id}/password';
export const API_UPDATE_AVATAR_URL = API + 'users/{id}/avatar';
export const API_DELETE_AVATAR_URL = API + 'users/{id}/avatar';

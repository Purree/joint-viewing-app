import {API} from "@/api/api_prefixes"

export const API_CURRENT_USER_URL = API + 'users/me';
export const API_CHANGE_NICKNAME_URL = API + 'users/{id}/name/';
export const API_CHANGE_PASSWORD_URL = API + 'users/{id}/password/';

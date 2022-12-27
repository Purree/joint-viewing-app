import { API } from '@/api/api_prefixes.js'

export const API_LOGIN_URL = ['post', API + 'login']
export const API_REGISTRATION_URL = ['post', API + 'users']
export const API_LOGOUT_URL = ['post', API + 'logout']
export const API_PASSWORD_RECOVERY_URL = ['put', API + 'users/password']

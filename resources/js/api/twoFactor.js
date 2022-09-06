import {API} from "@/api/api_prefixes.js"

export const API_TWO_FACTOR_LOGIN_URL = ['post', API + 'login/two-factor'];
export const API_TWO_FACTOR_ENABLE_URL = ['post', API + 'users/{user}/two-factor/authentication'];
export const API_TWO_FACTOR_DISABLE_URL = ['post', API + 'users/{user}/two-factor/authentication'];
export const API_TWO_FACTOR_GET_QR_CODE_URL = ['get', API + 'users/{user}/two-factor/qr-code'];
export const API_TWO_FACTOR_GET_RECOVERY_CODES_URL = ['get', API + 'users/{user}/two-factor/recovery-codes'];
export const API_TWO_FACTOR_REGENERATE_RECOVERY_CODES_URL = ['put', API + 'users/{user}/two-factor/recovery-codes'];

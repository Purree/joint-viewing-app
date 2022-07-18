import {API} from "@/api/api_prefixes"

export const API_TWO_FACTOR_LOGIN_URL = API + 'login/two-factor'
export const API_TWO_FACTOR_ENABLE_URL = API + 'users/{user}/two-factor/authentication'
export const API_TWO_FACTOR_DISABLE_URL = API + 'users/{user}/two-factor/authentication'
export const API_TWO_FACTOR_GET_QR_CODE_URL = API + 'users/{user}/two-factor/qr-code'
export const API_TWO_FACTOR_GET_RECOVERY_CODES_URL = API + 'users/{user}/two-factor/recovery-codes'
export const API_TWO_FACTOR_REGENERATE_RECOVERY_CODES_URL = API + 'users/{user}/two-factor/recovery-codes'

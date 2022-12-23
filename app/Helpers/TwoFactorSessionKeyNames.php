<?php

namespace App\Helpers;

enum TwoFactorSessionKeyNames: string
{
    case LOGIN_ATTEMPT = 'login.id';
    case TURNING_ON_ATTEMPT = 'two_factor_secret_key';
}

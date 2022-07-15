<?php

namespace App\Http\Controllers\TwoFactor;

use App\Services\Results\ResponseResult;
use App\Services\TwoFactorAuthenticationProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConfirmedTwoFactorAuthenticationController extends Controller
{
    /**
     * Enable two-factor authentication for the user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        $code = $request->input('code');

        if (empty($user->two_factor_secret) ||
            empty($code) ||
            ! TwoFactorAuthenticationProvider::verify(decrypt($user->two_factor_secret), $code)) {
            return ResponseResult::error('The provided two factor authentication code was invalid.')->error;
        }

        return ResponseResult::success()->returnValue;
    }
}

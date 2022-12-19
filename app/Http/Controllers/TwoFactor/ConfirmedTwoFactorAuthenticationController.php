<?php

namespace App\Http\Controllers\TwoFactor;

use App\Models\User;
use App\Services\Results\ResponseResult;
use App\Services\TwoFactorAuthenticationProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ConfirmedTwoFactorAuthenticationController extends Controller
{
    /**
     * Enable two-factor authentication for the user.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function store(Request $request, User $user): JsonResponse
    {
        $code = $request->input('code');

        if (empty($user->two_factor_secret) ||
            empty($code) ||
            ! TwoFactorAuthenticationProvider::verify(decrypt($user->two_factor_secret), $code)) {
            return ResponseResult::error(
                ['code' => ['The provided two factor authentication code was invalid.']],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return ResponseResult::success();
    }
}

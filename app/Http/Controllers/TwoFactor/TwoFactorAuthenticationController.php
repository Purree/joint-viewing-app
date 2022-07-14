<?php

namespace App\Http\Controllers\TwoFactor;

use App\Services\Results\ResponseResult;
use App\Services\Secrets\TwoFactorSecret;
use App\Services\TwoFactorAuthenticationProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use JsonException;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * Enable two-factor authentication for the user.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws JsonException
     */
    public function store(Request $request): JsonResponse
    {
        $request->user()->forceFill([
            'two_factor_secret' => encrypt(TwoFactorAuthenticationProvider::class->generateSecretKey()),
            'two_factor_recovery_codes' => encrypt(
                json_encode(
                    Collection::times(8, static function () {
                        return TwoFactorSecret::create();
                    })->all(),
                    JSON_THROW_ON_ERROR
                )
            ),
        ])->save();

        return ResponseResult::success()->returnValue;
    }

    /**
     * Disable two-factor authentication for the user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();

        return ResponseResult::success()->returnValue;
    }
}

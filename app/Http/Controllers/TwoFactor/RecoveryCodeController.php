<?php

namespace App\Http\Controllers\TwoFactor;

use App\Services\Results\ResponseResult;
use App\Services\Secrets\TwoFactorSecret;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use JsonException;

class RecoveryCodeController extends Controller
{
    /**
     * Get the two-factor authentication recovery codes for authenticated user.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws JsonException
     */
    public function index(Request $request): JsonResponse
    {
        if (! $request->user()->two_factor_secret ||
            ! $request->user()->two_factor_recovery_codes) {
            return ResponseResult::error(
                'Two factor authentication has not been enabled.',
                Response::HTTP_NOT_FOUND
            )->error;
        }

        return ResponseResult::success(
            json_decode(
                decrypt(
                    $request->user()->two_factor_recovery_codes
                ),
                true,
                512,
                JSON_THROW_ON_ERROR
            )
        )->returnValue;
    }

    /**
     * Generate a fresh set of two-factor authentication recovery codes.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws JsonException
     */
    public function store(Request $request): JsonResponse
    {
        $request->user()->forceFill([
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
}

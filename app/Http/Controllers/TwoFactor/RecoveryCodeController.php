<?php

namespace App\Http\Controllers\TwoFactor;

use App\Models\User;
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
     * @param  User  $user
     * @return JsonResponse
     *
     * @throws JsonException
     */
    public function index(Request $request, User $user): JsonResponse
    {
        if (! $user->two_factor_secret ||
            ! $user->two_factor_recovery_codes) {
            return ResponseResult::error(
                'Two factor authentication has not been enabled.',
                Response::HTTP_NOT_FOUND
            )->error;
        }

        return ResponseResult::success(
            json_decode(
                decrypt(
                    $user->two_factor_recovery_codes
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
     * @param  User  $user
     * @return JsonResponse
     *
     * @throws JsonException
     */
    public function store(Request $request, User $user): JsonResponse
    {
        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(
                json_encode(
                    Collection::times(8, static function () {
                        return TwoFactorSecret::create()['phrase'];
                    })->all(),
                    JSON_THROW_ON_ERROR
                )
            ),
        ])->save();

        return ResponseResult::success()->returnValue;
    }
}

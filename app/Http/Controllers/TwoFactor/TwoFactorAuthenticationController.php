<?php

namespace App\Http\Controllers\TwoFactor;

use App\Helpers\Results\ResponseResult;
use App\Helpers\Secrets\TwoFactorSecret;
use App\Helpers\TwoFactorAuthenticationProvider;
use App\Helpers\TwoFactorSessionKeyNames;
use App\Http\Requests\EnableTwoFactorRequest;
use App\Models\User;
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
     * @param  User  $user
     * @return JsonResponse
     *
     * @throws JsonException
     */
    public function store(EnableTwoFactorRequest $request, User $user): JsonResponse
    {
        $secret = $request->session()->get(TwoFactorSessionKeyNames::TURNING_ON_ATTEMPT->value);

        if (!TwoFactorAuthenticationProvider::verify(decrypt($secret), $request->code)) {
            return ResponseResult::error('The provided two factor authentication code was invalid.');
        }

        $request->session()->forget(TwoFactorSessionKeyNames::TURNING_ON_ATTEMPT->value);

        $user->forceFill([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => encrypt(
                json_encode(
                    Collection::times(8, static function () {
                        return TwoFactorSecret::create()['phrase'];
                    })->all(),
                    JSON_THROW_ON_ERROR
                )
            ),
        ])->save();

        return ResponseResult::success();
    }

    /**
     * Disable two-factor authentication for the user.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function destroy(Request $request, User $user): JsonResponse
    {
        $request->session()->forget(TwoFactorSessionKeyNames::TURNING_ON_ATTEMPT->value);
        $user->disableTwoFactor();

        return ResponseResult::success();
    }
}

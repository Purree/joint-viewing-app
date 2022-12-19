<?php

namespace App\Http\Controllers\TwoFactor;

use App\Http\Requests\TwoFactorLoginRequest;
use App\Services\Results\ResponseResult;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use JsonException;

class TwoFactorAuthenticatedSessionController extends Controller
{
    /**
     * Attempt to authenticate a new session using the two-factor authentication code.
     *
     * @param  TwoFactorLoginRequest  $request
     * @return mixed
     *
     * @throws JsonException
     */
    public function store(TwoFactorLoginRequest $request)
    {
        $user = $request->challengedUser();

        if ($code = $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($code);
        } elseif (! $request->hasValidCode()) {
            return ResponseResult::error(
                ['code' => ['The provided two factor authentication code was invalid.']],
                Response::HTTP_UNAUTHORIZED
            );
        }

        Auth::login($user);

        $request->session()->regenerate();

        return ResponseResult::success();
    }
}

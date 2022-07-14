<?php

namespace App\Http\Controllers\TwoFactor;

use App\Http\Requests\TwoFactorLoginRequest;
use App\Services\Results\ResponseResult;
use Auth;
use Illuminate\Routing\Controller;

class TwoFactorAuthenticatedSessionController extends Controller
{
    /**
     * Attempt to authenticate a new session using the two-factor authentication code.
     *
     * @param  TwoFactorLoginRequest  $request
     * @return mixed
     */
    public function store(TwoFactorLoginRequest $request)
    {
        $user = $request->challengedUser();

        if ($code = $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($code);
        } elseif (! $request->hasValidCode()) {
            return ResponseResult::error('The provided two factor authentication code was invalid')->error;
        }

        Auth::login($user);

        $request->session()->regenerate();

        return ResponseResult::success()->returnValue;
    }
}

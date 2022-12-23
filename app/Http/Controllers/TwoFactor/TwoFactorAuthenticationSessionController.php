<?php

namespace App\Http\Controllers\TwoFactor;

use App\Helpers\Results\ResponseResult;
use App\Helpers\TwoFactorAuthenticationProvider;
use App\Helpers\TwoFactorSessionKeyNames;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TwoFactorAuthenticationSessionController extends Controller
{
    public function store(Request $request, User $user): JsonResponse
    {
        $twoFactorSecretKey = encrypt(TwoFactorAuthenticationProvider::generateSecretKey());

        $request->session()->put(
            TwoFactorSessionKeyNames::TURNING_ON_ATTEMPT->value,
            $twoFactorSecretKey
        );

        return ResponseResult::success();
    }
}

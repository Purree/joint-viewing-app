<?php

namespace App\Http\Controllers\TwoFactor;

use App\Helpers\Results\ResponseResult;
use App\Helpers\TwoFactorAuthenticationProvider;
use App\Helpers\TwoFactorSessionKeyNames;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TwoFactorAuthenticationSessionQrCodeController extends Controller
{
    /**
     * Get the SVG element for the user's two factor authentication QR code.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function show(Request $request, User $user): JsonResponse
    {
        if (is_null($request->session()->get(TwoFactorSessionKeyNames::TURNING_ON_ATTEMPT->value))) {
            return ResponseResult::error(
                'Two factor authentication has not been enabled.',
                Response::HTTP_NOT_FOUND
            );
        }

        return ResponseResult::success(
            TwoFactorAuthenticationProvider::getQrCode(
                $user->name,
                decrypt($request->session()->get(TwoFactorSessionKeyNames::TURNING_ON_ATTEMPT->value))
            )
        );
    }
}

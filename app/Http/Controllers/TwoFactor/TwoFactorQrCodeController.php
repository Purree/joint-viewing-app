<?php

namespace App\Http\Controllers\TwoFactor;

use App\Models\User;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TwoFactorQrCodeController extends Controller
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
        if (is_null($user->two_factor_secret)) {
            return ResponseResult::error(
                'Two factor authentication has not been enabled.',
                Response::HTTP_NOT_FOUND
            );
        }

        return ResponseResult::success([
            'svg' => $user->twoFactorQrCodeSvg(),
            'url' => $user->twoFactorQrCodeUrl(),
        ]);
    }
}

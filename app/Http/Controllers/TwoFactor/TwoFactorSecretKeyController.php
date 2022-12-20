<?php

namespace App\Http\Controllers\TwoFactor;

use App\Helpers\Results\ResponseResult;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TwoFactorSecretKeyController extends Controller
{
    /**
     * Get the current user's two-factor authentication setup / secret key.
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

        return  ResponseResult::success([
            'secretKey' => decrypt($user->two_factor_secret),
        ]);
    }
}

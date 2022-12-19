<?php

namespace App\Http\Controllers\AuthMethods;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use App\Models\User;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TokenController extends Controller implements AuthMethodControllerInterface
{
    public function getAll(Request $request, User $user): JsonResponse
    {
        return ResponseResult::success(
            TokenResource::collection($user->tokens()->get())
        );
    }

    public function revokeAll(Request $request, User $user): JsonResponse
    {
        $user->tokens()->delete();

        return ResponseResult::success();
    }

    public function revoke(Request $request, User $user, int|string $authId): JsonResponse
    {
        $token = $user->tokens()->where('id', $authId)->first();

        if ($token === null) {
            return ResponseResult::error(['token' => ['Token not found']], Response::HTTP_NOT_FOUND);
        }

        $token->delete();

        return ResponseResult::success(
            [
                'logout' => method_exists(auth()->user()->currentAccessToken(), 'delete')
                    && $token->token === auth()->user()?->currentAccessToken()?->token,
            ]
        );
    }
}

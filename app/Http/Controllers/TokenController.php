<?php

namespace App\Http\Controllers;

use App\Http\Resources\TokenResource;
use App\Models\User;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TokenController extends Controller
{
    public function getAll(Request $request, User $user): JsonResponse
    {
        return ResponseResult::success(
            TokenResource::collection($user->tokens()->get())
        )->returnValue;
    }

    public function revokeAll(Request $request, User $user): JsonResponse
    {
        $user->tokens()->delete();

        return ResponseResult::success()->returnValue;
    }

    public function revoke(Request $request, User $user, int $tokenId): JsonResponse
    {
        $token = $user->tokens()->where('id', $tokenId)->first();

        if ($token === null) {
            return ResponseResult::error(['token' => ['Token not found']], Response::HTTP_NOT_FOUND)->error;
        }

        $token->delete();

        return ResponseResult::success(
            [
                'logout' => method_exists(auth()->user()->currentAccessToken(), 'delete')
                    && $token->token === auth()->user()?->currentAccessToken()?->token,
            ]
        )->returnValue;
    }
}

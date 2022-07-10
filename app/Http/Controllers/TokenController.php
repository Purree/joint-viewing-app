<?php

namespace App\Http\Controllers;

use App\Http\Resources\TokenResource;
use App\Models\User;
use App\Services\Results\ResponseResult;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function getAllTokens(Request $request, User $user): JsonResponse
    {
        return ResponseResult::success(
            TokenResource::collection($user->tokens()->get())
        )->returnValue;
    }

    public function revokeAllTokens(Request $request, User $user): JsonResponse
    {
        $user->tokens()->delete();

        return ResponseResult::success()->returnValue;
    }

    public function revokeToken(Request $request, User $user, int $tokenId): JsonResponse
    {
        $token = $user->tokens()->where('id', $tokenId);

        if ($token->first() === null) {
            return ResponseResult::error(['token' => ['Token not found']], Response::HTTP_NOT_FOUND)->error;
        }

        $token->delete();
        return ResponseResult::success()->returnValue;
    }
}

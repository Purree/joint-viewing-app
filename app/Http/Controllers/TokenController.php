<?php

namespace App\Http\Controllers;

use App\Http\Resources\TokenResource;
use App\Models\User;
use App\Services\Results\ResponseResult;
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
}

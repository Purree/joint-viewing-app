<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $token = Auth::user()->createToken('api');
            return response()->json([
                'token' => $token->plainTextToken
            ]);
        }

        return response()->json([], Response::HTTP_UNAUTHORIZED);
    }
}

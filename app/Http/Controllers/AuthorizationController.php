<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthorizationController extends Controller
{
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $token = Auth::user()->createToken('api');

            return ResponseResult::success([
                'token' => $token->plainTextToken,
            ])->returnValue;
        }

        return ResponseResult::error(['auth' => ['Incorrect user or password.']], Response::HTTP_UNAUTHORIZED)
            ->error;
    }

    public function registration(RegisterUserRequest $request): JsonResponse
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return ResponseResult::success()->returnValue;
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return ResponseResult::error()->error;
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $token = auth()->user()->currentAccessToken();
            if ($token && method_exists($token, 'delete')) {
                auth()->user()->currentAccessToken()->delete();
            }

            auth()->guard('web')->logout();

            return ResponseResult::success()->returnValue;
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return ResponseResult::error()->error;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RecoveryPasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\Results\ResponseResult;
use App\Services\Secret;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\Concerns\Has;

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
        $secret = Secret::create();
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'secret' => $secret['hash'],
        ]);

        return ResponseResult::success(['secret_phrase' => $secret['phrase']])->returnValue;
    }

    public function logout(Request $request): JsonResponse
    {
        $token = auth()->user()->currentAccessToken();
        if ($token && method_exists($token, 'delete')) {
            auth()->user()->currentAccessToken()->delete();
        }

        auth()->guard('web')->logout();

        return ResponseResult::success()->returnValue;
    }

    public function recoveryPassword(RecoveryPasswordRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->secret, $user->secret)) {
            return ResponseResult::error(
                ['secret' => ['Incorrect secret']],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )->error;
        }

        $secret = Secret::create();

        $user->secret = $secret['hash'];
        $user->password = Hash::make($request->password);
        $user->save();

        return ResponseResult::success(['new_secret_phrase' => $secret['phrase']])->returnValue;
    }
}

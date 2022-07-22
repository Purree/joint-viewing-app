<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RecoveryPasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\TwoFactorLoginRequest;
use App\Models\User;
use App\Services\Results\ResponseResult;
use App\Services\Secrets\Secret;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthorizationController extends Controller
{
    public function login(LoginUserRequest $request): JsonResponse
    {
        $attempt_user = User::where('email', $request->email)->first();

        if (! ($attempt_user && Hash::check($request->password, $attempt_user->password))) {
            return ResponseResult::error(['auth' => ['Incorrect user or password.']], Response::HTTP_UNAUTHORIZED)
                ->error;
        }

        if ($attempt_user->hasEnabledTwoFactorAuthentication()) {
            $request->session()->put(TwoFactorLoginRequest::SESSION_TWO_FACTOR_NAME, $attempt_user->id);

            return ResponseResult::success(['two-factor' => true])->returnValue;
        }

        Auth::login($attempt_user);

        if (! $request->token) {
            return ResponseResult::success()->returnValue;
        }

        $token = Auth::user()->createToken('api');

        return ResponseResult::success([
            'token' => $token->plainTextToken,
        ])->returnValue;
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

        if (! Hash::check($request->secret, $user->secret)) {
            return ResponseResult::error(
                ['secret' => ['Incorrect secret']],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )->error;
        }

        $secret = Secret::create();

        $user->tokens()->delete();
        $user->sessions()->delete();

        $user->secret = $secret['hash'];
        $user->password = Hash::make($request->password);
        $user->save();

        $user->disableTwoFactor();

        return ResponseResult::success(['new_secret_phrase' => $secret['phrase']])->returnValue;
    }
}

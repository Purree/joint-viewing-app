<?php

namespace App\Services;

use App\Models\User;
use App\Services\Results\FunctionResult;
use App\Services\Secrets\Secret;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class AuthorizationService
{
    public function login(string $email, string $password, ?bool $need_token = null): FunctionResult
    {
        $attempt_user = User::where('email', $email)->first();

        if (! ($attempt_user && Hash::check($password, $attempt_user->password))) {
            return FunctionResult::error(['auth' => ['Incorrect user or password.']]);
        }

        if ($attempt_user->hasEnabledTwoFactorAuthentication()) {
            return FunctionResult::success(['two-factor' => true, 'attempt_user' => $attempt_user]);
        }

        Auth::login($attempt_user);

        $additional_data = [];

        if ($need_token) {
            $token = Auth::user()->createToken('api');

            $additional_data['token'] = [
                $token->plainTextToken,
            ];
        }

        return FunctionResult::success($additional_data);
    }

    public function registration(string $name, string $email, string $password): FunctionResult
    {
        $password_recovery_secret = Secret::create();
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'secret' => $password_recovery_secret['hash'],
        ]);

        return FunctionResult::success(
            ['secret_phrase' => $password_recovery_secret['phrase']],
        );
    }

    public function logout(): FunctionResult
    {
        $token = auth()->user()->currentAccessToken();
        if ($token && method_exists($token, 'delete')) {
            auth()->user()->currentAccessToken()->delete();
        }

        auth()->guard('web')->logout();

        return FunctionResult::success();
    }

    public function recoveryPassword(string $email, string $password, string $password_recovery_secret): FunctionResult
    {
        $user = User::where('email', $email)->first();

        if (! Hash::check($password_recovery_secret, $user->secret)) {
            return FunctionResult::error(
                ['secret' => ['Incorrect secret']],
            );
        }

        $new_password_recovery_secret = Secret::create();

        $user->tokens()->delete();
        $user->sessions()->delete();

        $user->secret = $new_password_recovery_secret['hash'];
        $user->password = Hash::make($password);
        $user->save();

        $user->disableTwoFactor();

        return FunctionResult::success(['new_secret_phrase' => $new_password_recovery_secret['phrase']]);
    }
}

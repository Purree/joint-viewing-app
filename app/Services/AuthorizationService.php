<?php

namespace App\Services;

use App\Models\User;
use App\Services\Results\FunctionResult;
use App\Services\Secrets\Secret;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class AuthorizationService
{
    public function login(string $email, string $password, bool $remember, ?bool $needToken = null): FunctionResult
    {
        $attemptUser = User::where('email', $email)->first();

        if (! ($attemptUser && Hash::check($password, $attemptUser->password))) {
            return FunctionResult::error(['auth' => ['Incorrect user or password.']]);
        }

        if ($attemptUser->hasEnabledTwoFactorAuthentication()) {
            return FunctionResult::success(['two-factor' => true, 'attempt_user' => $attemptUser]);
        }

        Auth::login($attemptUser, $remember);

        $additionalData = [];

        if ($needToken) {
            $token = Auth::user()->createToken('api');

            $additionalData['token'] = [
                $token->plainTextToken,
            ];
        }

        return FunctionResult::success($additionalData);
    }

    public function registration(string $name, string $email, string $password): FunctionResult
    {
        $passwordRecoverySecret = Secret::create();
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'secret' => $passwordRecoverySecret['hash'],
        ]);

        return FunctionResult::success(
            ['secret_phrase' => $passwordRecoverySecret['phrase']],
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

    public function recoveryPassword(string $email, string $password, string $passwordRecoverySecret): FunctionResult
    {
        $user = User::where('email', $email)->first();

        if (! Hash::check($passwordRecoverySecret, $user->secret)) {
            return FunctionResult::error(
                ['secret' => ['Incorrect secret']],
            );
        }

        $newPasswordRecoverySecret = Secret::create();

        $user->tokens()->delete();
        $user->sessions()->delete();

        $user->secret = $newPasswordRecoverySecret['hash'];
        $user->password = Hash::make($password);
        $user->save();

        $user->disableTwoFactor();

        return FunctionResult::success(['new_secret_phrase' => $newPasswordRecoverySecret['phrase']]);
    }
}

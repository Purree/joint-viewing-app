<?php

namespace App\Services;

use App\Exceptions\InvalidArgumentException;
use App\Models\User;
use App\Services\Results\FunctionResult;
use App\Services\Secrets\Secret;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class AuthorizationService
{
    /**
     * @throws InvalidArgumentException
     */
    public function login(string $email, string $password, bool $remember, ?bool $needToken = null): array
    {
        $attemptUser = User::where('email', $email)->first();

        if (!($attemptUser && Hash::check($password, $attemptUser->password))) {
            return throw new InvalidArgumentException('Incorrect user or password.');
        }

        if ($attemptUser->hasEnabledTwoFactorAuthentication()) {
            return ['two-factor' => true, 'attempt_user' => $attemptUser];
        }

        Auth::login($attemptUser, $remember);

        $additionalData = [];

        if ($needToken) {
            $token = Auth::user()->createToken('api');

            $additionalData['token'] = [
                $token->plainTextToken,
            ];
        }

        return $additionalData;
    }

    public function registration(string $name, string $email, string $password): array
    {
        $passwordRecoverySecret = Secret::create();
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'secret' => $passwordRecoverySecret['hash'],
        ]);

        return ['secret_phrase' => $passwordRecoverySecret['phrase']];
    }

    public function logout(): void
    {
        $token = auth()->user()->currentAccessToken();
        if ($token && method_exists($token, 'delete')) {
            auth()->user()->currentAccessToken()->delete();
        }

        auth()->guard('web')->logout();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function recoveryPassword(string $email, string $password, string $passwordRecoverySecret): array
    {
        $user = User::where('email', $email)->first();

        if (!Hash::check($passwordRecoverySecret, $user->secret)) {
            throw new InvalidArgumentException(
                'Incorrect secret',
            );
        }

        $newPasswordRecoverySecret = Secret::create();

        $user->tokens()->delete();
        $user->sessions()->delete();

        $user->secret = $newPasswordRecoverySecret['hash'];
        $user->password = Hash::make($password);
        $user->save();

        $user->disableTwoFactor();

        return ['new_secret_phrase' => $newPasswordRecoverySecret['phrase']];
    }
}

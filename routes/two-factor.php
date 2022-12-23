<?php

use App\Http\Controllers\TwoFactor\ConfirmedTwoFactorAuthenticationController;
use App\Http\Controllers\TwoFactor\RecoveryCodeController;
use App\Http\Controllers\TwoFactor\TwoFactorAuthenticatedSessionController;
use App\Http\Controllers\TwoFactor\TwoFactorAuthenticationController;
use App\Http\Controllers\TwoFactor\TwoFactorAuthenticationSessionController;
use App\Http\Controllers\TwoFactor\TwoFactorAuthenticationSessionQrCodeController;
use App\Http\Controllers\TwoFactor\TwoFactorSecretKeyController;

Route::middleware(['can:use-authenticated-route,user', 'auth:sanctum'])->group(static function () {
    Route::post('/users/{user}/two-factor/authentication', [TwoFactorAuthenticationSessionController::class, 'store'])
        ->name('two-factor.create');

    Route::put('/users/{user}/two-factor/authentication', [TwoFactorAuthenticationController::class, 'store'])
        ->name('two-factor.store');

    Route::delete('/users/{user}/two-factor/authentication', [TwoFactorAuthenticationController::class, 'destroy'])
        ->name('two-factor.disable');

    Route::get('/users/{user}/two-factor/qr-code', [TwoFactorAuthenticationSessionQrCodeController::class, 'show'])
        ->name('two-factor.qr-code');

    Route::get('/users/{user}/two-factor/secret-key', [TwoFactorSecretKeyController::class, 'show'])
        ->name('two-factor.secret-key');

    Route::get('/users/{user}/two-factor/recovery-codes', [RecoveryCodeController::class, 'index'])
        ->name('two-factor.recovery-codes');

    Route::put('/users/{user}/two-factor/recovery-codes', [RecoveryCodeController::class, 'store']);

    Route::post(
        '/users/{user}/confirmed-two-factor/authentication',
        [ConfirmedTwoFactorAuthenticationController::class, 'store']
    )->name('two-factor.confirm');
});

Route::post('/login/two-factor/', [TwoFactorAuthenticatedSessionController::class, 'store']);

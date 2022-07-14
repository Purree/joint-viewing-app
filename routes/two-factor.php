<?php

use App\Http\Controllers\TwoFactor\ConfirmedTwoFactorAuthenticationController;
use App\Http\Controllers\TwoFactor\RecoveryCodeController;
use App\Http\Controllers\TwoFactor\TwoFactorAuthenticatedSessionController;
use App\Http\Controllers\TwoFactor\TwoFactorAuthenticationController;
use App\Http\Controllers\TwoFactor\TwoFactorQrCodeController;
use App\Http\Controllers\TwoFactor\TwoFactorSecretKeyController;

Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);

Route::post('/users/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
    ->name('two-factor.enable');

Route::post(
    '/users/confirmed-two-factor-authentication',
    [ConfirmedTwoFactorAuthenticationController::class, 'store']
)->name('two-factor.confirm');

Route::delete('/users/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
    ->name('two-factor.disable');

Route::get('/users/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
    ->name('two-factor.qr-code');

Route::get('/users/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
    ->name('two-factor.secret-key');

Route::get('/users/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
    ->name('two-factor.recovery-codes');

Route::post('/users/two-factor-recovery-codes', [RecoveryCodeController::class, 'store']);

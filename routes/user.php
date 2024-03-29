<?php

use App\Http\Controllers\AuthMethods\SessionController;
use App\Http\Controllers\AuthMethods\TokenController;
use App\Http\Controllers\UserController;

Route::name('users.')->prefix('users')->group(static function () {
    Route::get('/me', [UserController::class, 'showAuthenticated'])->name('me');

    Route::middleware('can:use-authenticated-route,user')->prefix('/{user}')->group(static function () {
        Route::put('/name/', [UserController::class, 'changeName'])->name('change-name')->middleware(
            ['throttle:change_name']
        );

        // Doesn't "put" method because laravel can't get files from put requests
        Route::post('/avatar/', [UserController::class, 'changeAvatar'])->name('change-avtar')->middleware(
            ['throttle:change_avatar']
        );

        Route::delete('/avatar/', [UserController::class, 'deleteAvatar'])->name('delete-avtar');

        Route::put('/password/', [UserController::class, 'changePassword'])->name(
            'change-password'
        )->middleware(['throttle:change_password']);

        Route::get('/tokens', [TokenController::class, 'getAll'])->name('get-all-tokens');

        Route::delete('/tokens', [TokenController::class, 'revokeAll'])->name('revoke-all-tokens');

        Route::delete('/tokens/{token}', [TokenController::class, 'revoke'])->name('revoke-token');

        Route::get('/sessions', [SessionController::class, 'getAll'])->name('get-all-sessions');

        Route::delete('/sessions', [SessionController::class, 'revokeAll'])->name(
            'revoke-all-sessions'
        );

        Route::delete('/sessions/{session}', [SessionController::class, 'revoke'])->name(
            'revoke-session'
        );
    });
});

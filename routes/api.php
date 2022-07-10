<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('throttle:auth')->group(static function () {
    Route::post('/login', [AuthorizationController::class, 'login']);
    Route::post('/users', [AuthorizationController::class, 'registration'])->middleware('throttle:register');
    Route::put('/users/password', [AuthorizationController::class, 'recoveryPassword']);
});

Route::middleware('auth:sanctum')->group(static function () {
    Route::post('/logout', [AuthorizationController::class, 'logout']);

    Route::name('users.')->prefix('users')->group(static function () {
        Route::get('/me', [UserController::class, 'showAuthenticated'])->name('me');

        Route::middleware('can:use-authenticated-route,user')->group(static function () {
            Route::put('{user}/name/', [UserController::class, 'changeName'])->name('change-name')->middleware(
                ['throttle:change_name']
            );

            Route::put('{user}/password/', [UserController::class, 'changePassword'])->name(
                'change-password'
            )->middleware(['throttle:change_password']);

            Route::get('/{user}/tokens', [TokenController::class, 'getAllTokens'])->name('get-all-tokens');

            Route::delete('/{user}/tokens', [TokenController::class, 'revokeAllTokens'])->name('revoke-all-tokens');

            Route::delete('/{user}/tokens/{token}', [TokenController::class, 'revokeToken'])->name('revoke-token');

            Route::get('/{user}/sessions', [SessionController::class, 'getAllSessions'])->name('get-all-sessions');

            Route::delete('/{user}/sessions', [SessionController::class, 'revokeAllSessions'])->name(
                'revoke-all-sessions'
            );

            Route::delete('/{user}/sessions/{session}', [SessionController::class, 'revokeSession'])->name(
                'revoke-session'
            );
        });
    });
});

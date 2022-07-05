<?php

use App\Http\Controllers\AuthorizationController;
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

        Route::put('/name/{user}', [UserController::class, 'changeName'])->name('change-name')->middleware(
            ['throttle:change_name', 'can:use-authenticated-route,user']
        );

        Route::put('/password/{user}', [UserController::class, 'changePassword'])->name(
            'change-password'
        )->middleware(['throttle:change_password', 'can:use-authenticated-route,user']);
    });

    Route::name('tokens.')->prefix('tokens')->group(static function () {
        Route::get('/{id}', [TokenController::class, 'getAllTokens'])->name('get-all-tokens');
    });
});

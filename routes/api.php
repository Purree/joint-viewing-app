<?php

use App\Http\Controllers\AuthorizationController;
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
    Route::post('/registration', [AuthorizationController::class, 'registration'])->middleware('throttle:register');
    Route::post('/forgot-password', [AuthorizationController::class, 'recoveryPassword']);
});

Route::middleware('auth:sanctum')->group(static function () {
    Route::post('/logout', [AuthorizationController::class, 'logout']);

    Route::name('users.')->prefix('users')->group(static function () {
        Route::get('/me', [UserController::class, 'showAuthenticated'])->name('me');

        Route::patch('/change-name', [UserController::class, 'changeName'])->name('change-name')->middleware(
            'throttle:change_name'
        );

        Route::patch('/change-password', [UserController::class, 'changePassword'])->name(
            'change-password'
        )->middleware('throttle:change_password');
    });
});

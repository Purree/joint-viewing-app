<?php

use App\Http\Controllers\AuthMethods\SessionController;
use App\Http\Controllers\AuthMethods\TokenController;
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
    Route::post('/users', [AuthorizationController::class, 'registration'])->middleware('throttle:register');
    Route::put('/users/password', [AuthorizationController::class, 'recoveryPassword']);
});

require 'two-factor.php';

Route::middleware('auth:sanctum')->group(static function () {
    Route::post('/logout', [AuthorizationController::class, 'logout']);

    require 'user.php';

    require 'room.php';
});

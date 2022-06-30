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

Route::post('/login', [AuthorizationController::class, 'login']);
Route::post('/registration', [AuthorizationController::class, 'registration']);
Route::post('/logout', [AuthorizationController::class, 'logout']);

Route::middleware('auth:sanctum')->group(static function () {

    Route::name('users.')->prefix('users')->group(static function () {
        Route::get('/me', [UserController::class, 'show_authenticated'])->name('me');
    });
});

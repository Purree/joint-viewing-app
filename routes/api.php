<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::post('/login', [LoginController::class, 'login']);
Route::post('/registration', [RegisterController::class, 'registration']);

Route::middleware('auth:sanctum')->group(static function () {
    Route::name('users.')->prefix('users')->group(static function () {
        Route::get('/me', [UserController::class, 'show_authenticated'])->name('me');
    });
});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', [App\Http\Controllers\MainController::class, 'index'])
    ->where('any', '^(?!api).*$');

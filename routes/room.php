<?php

use App\Http\Controllers\RoomController;

Route::name('rooms.')->prefix('rooms')->group(static function () {
    Route::get('/', [RoomController::class, 'index'])->name('index');

    Route::middleware('can:interact,room')->prefix('{room}')->group(static function () {
        Route::delete('/', [RoomController::class, 'destroy'])->middleware('can:delete,room')->name('destroy');
        Route::post('/leave', [RoomController::class, 'leave'])->name('leave');
    });
});

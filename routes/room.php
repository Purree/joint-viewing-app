<?php

use App\Http\Controllers\RoomController;

Route::name('rooms.')->prefix('rooms')->group(static function () {
    Route::get('/', [RoomController::class, 'index'])->name('all');
});

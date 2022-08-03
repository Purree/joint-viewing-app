<?php

use App\Http\Controllers\RoomController;

Route::name('rooms.')->prefix('rooms')->group(static function () {
    Route::get('/', [RoomController::class, 'index'])->name('index');
    Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy')->middleware('can:delete,room');
});

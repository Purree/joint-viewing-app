<?php

use App\Http\Controllers\RoomController;

Route::name('rooms.')->prefix('rooms')->controller(RoomController::class)->group(static function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'create')->name('create');
    Route::post('{room}/join', 'join')->name('join');

    Route::middleware('can:interact,room')->prefix('{room}')->group(static function () {
        Route::delete('/', 'destroy')->middleware('can:delete,room')->name('destroy');
        Route::put('/', 'update')->middleware('can:update,room')->name('update');
        Route::post('/leave', 'leave')->name('leave');
        Route::post('/kick/{user}', 'kick')->middleware('can:kick,room')->name('kick');
    });
});

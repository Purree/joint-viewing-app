<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoomController;

Route::name('rooms.')->prefix('rooms')->group(static function () {
    Route::controller(RoomController::class)->group(static function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');

        Route::get('/link/{room:link}/', 'show')->name('show.by-link');
        Route::prefix('{room}')->group(static function () {
            Route::post('/join', 'join')->name('join');
            Route::get('/', 'show')->name('show');

            Route::middleware('can:interact,room')->group(static function () {
                Route::delete('/', 'destroy')->middleware('can:delete,room')->name('destroy');
                Route::put('/', 'update')->middleware('can:update,room')->name('update');
                Route::post('/leave', 'leave')->name('leave');
                Route::post('/kick/{user}', 'kick')->middleware('can:kick,room')->name('kick');

                Route::name('chat.')->prefix('chat')->controller(ChatController::class)->group(static function () {
                    Route::prefix('messages')->group(static function () {
                        Route::get('/', 'index')->name('index');
                        Route::post('/', 'send')->name('send');
                    });
                });
            });
        });
    });
});

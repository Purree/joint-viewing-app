<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoomController;

Route::name('rooms.')->prefix('rooms')->group(static function () {
    Route::controller(RoomController::class)->group(static function () {
        Route::get('/', 'index')->name('index')->middleware(
            ['throttle:get_all_rooms_data']
        );
        Route::post('/', 'create')->name('create')->middleware(
            ['throttle:create_room']
        );

        Route::get('/link/{room:link}/', 'show')->name('show.by-link')->middleware(
            ['throttle:get_room_data']
        );
        Route::prefix('{room}')->group(static function () {
            Route::post('/join', 'join')->name('join')->middleware(
                ['throttle:join_room']
            );
            Route::get('/', 'show')->name('show')->middleware(
                ['throttle:get_room_data']
            );

            Route::middleware('can:interact,room')->group(static function () {
                Route::delete('/', 'destroy')->middleware('can:delete,room')->name('destroy');
                Route::put('/', 'update')->middleware('can:update,room', 'throttle:update_room_data')
                    ->name('update');
                Route::post('/leave', 'leave')->name('leave');
                Route::post('/kick/{user}', 'kick')->middleware('can:kick,room')->name('kick');

                Route::name('chat.')->prefix('chat')->controller(ChatController::class)->group(static function () {
                    Route::prefix('messages')->group(static function () {
                        Route::get('/', 'index')->name('index')->middleware(
                            ['throttle:get_all_messages']
                        );
                        Route::post('/', 'send')->name('send')->middleware(
                            ['throttle:send_message']
                        );
                    });
                });
            });
        });
    });
});

<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\Room\RoomMemberController;
use App\Http\Controllers\Room\RoomController;

Route::name('rooms.')->prefix('rooms')->group(static function () {
    Route::controller(RoomController::class)->group(static function () {
        Route::get('/', 'getAll')->name('get-all')->middleware(
            ['throttle:get_all_rooms_data']
        );
        Route::post('/', 'create')->name('create')->middleware(
            ['throttle:create_room']
        );

        Route::get('/link/{room:link}/', 'get')->name('get.by-link')->middleware(
            ['throttle:get_room_data']
        );
        Route::prefix('{room}')->group(static function () {
            Route::post('/join', [RoomMemberController::class, 'add'])->name('join')->middleware(
                ['throttle:join_room']
            );
            Route::get('/', 'get')->name('get')->middleware(
                ['throttle:get_room_data']
            );

            Route::middleware('can:interact,room')->group(static function () {
                Route::delete('/', 'destroy')->middleware('can:delete,room')->name('destroy');
                Route::put('/', 'update')->middleware('can:update,room', 'throttle:update_room_data')
                    ->name('update');
                Route::post('/leave', [RoomMemberController::class, 'leave'])->name('leave');

                Route::name('members.')->controller(RoomMemberController::class)
                    ->prefix('members')->group(static function () {
                        Route::get('/', 'getAll')->name('get-all');
                        Route::prefix('{user}')->group(static function () {
                            Route::delete('/', 'kick')
                                ->middleware('can:kick,room')
                                ->name('kick');
                        });
                    });

                Route::name('chat.')->prefix('chat')->controller(MessageController::class)->group(static function () {
                    Route::prefix('messages')->group(static function () {
                        Route::get('/', 'getAll')->name('get-all')->middleware(
                            ['throttle:get_all_messages']
                        );
                        Route::post('/', 'send')->name('send')->middleware(
                            ['throttle:send_message']
                        );
                    });
                });

                Route::name('orders.')->prefix('orders')->controller(OrderController::class)->group(static function () {
                    Route::get('/', 'getAll')->name('get-all')->middleware(
                        ['throttle:get_all_orders']
                    );
                    Route::post('/', 'add')->name('add')->middleware(
                        ['throttle:add_order', 'can:add,App\Models\Order,room']
                    );
                    Route::delete('/{order}', 'delete')->name('delete')->middleware(
                        ['throttle:delete_order', 'can:delete,App\Models\Order,room,order']
                    );
                });

                Route::name('player.')->prefix('player')->controller(PlayerController::class)->group(
                    static function () {
                        Route::post('/client/synchronize', 'synchronizationRequest')
                            ->name('synchronization-request')->middleware(
                                ['throttle:synchronization_request']
                            );
                        Route::post('/host/synchronize', 'synchronize')->name('synchronize')
                            ->middleware(['can:manipulate,room', 'throttle:synchronization']);
                    }
                );
            });
        });
    });
});

<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimiterServiceProvider extends ServiceProvider
{
    private const MAX_SYNCHRONIZATION_ATTEMPTS_COUNT = 100;

    public function boot()
    {
        RateLimiter::for('auth', static function () {
            return Limit::perMinute(5);
        });

        RateLimiter::for('register', static function () {
            return Limit::perMinute(5);
        });

        RateLimiter::for('change_name', static function () {
            return Limit::perHour(10);
        });

        RateLimiter::for('change_avatar', static function () {
            return Limit::perHour(10);
        });

        RateLimiter::for('change_password', static function () {
            return Limit::perMinute(10);
        });

        RateLimiter::for('get_all_rooms_data', static function () {
            return Limit::perMinute(20);
        });

        RateLimiter::for('create_room', static function () {
            return Limit::perMinute(5);
        });

        RateLimiter::for('join_room', static function () {
            return Limit::perMinute(5);
        });

        RateLimiter::for('update_room_data', static function () {
            return Limit::perMinute(5);
        });

        RateLimiter::for('get_room_data', static function () {
            return Limit::perMinute(20);
        });

        RateLimiter::for('get_all_messages', static function () {
            return Limit::perMinute(60);
        });

        RateLimiter::for('send_message', static function () {
            return Limit::perMinute(30);
        });

        RateLimiter::for('get_all_orders', static function () {
            return Limit::perMinute(10);
        });

        RateLimiter::for('add_order', static function () {
            return Limit::perMinute(10);
        });

        RateLimiter::for('get_first_order', static function () {
            return Limit::perMinute(60);
        });

        RateLimiter::for('delete_order', static function () {
            return Limit::perMinute(100);
        });

        RateLimiter::for('synchronization_request', static function (Request $request) {
            if ($request->user()->createdRoom->id === $request->user()->currentRoom->id) {
                return Limit::perMinute(self::MAX_SYNCHRONIZATION_ATTEMPTS_COUNT * 10);
            }

            return Limit::perMinute(self::MAX_SYNCHRONIZATION_ATTEMPTS_COUNT);
        });

        RateLimiter::for('synchronization', static function () {
            return Limit::perMinute(self::MAX_SYNCHRONIZATION_ATTEMPTS_COUNT*10);
        });
    }
}

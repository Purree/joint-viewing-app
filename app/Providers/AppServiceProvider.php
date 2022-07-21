<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        RateLimiter::for('auth', static function () {
            return Limit::perMinute(5);
        });

        RateLimiter::for('register', static function () {
            return Limit::perHour(1);
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
    }
}

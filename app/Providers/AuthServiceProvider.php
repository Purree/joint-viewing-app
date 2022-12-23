<?php

namespace App\Providers;

use App\Models\Room;
use App\Models\User;
use App\Policies\RoomPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Room::class => RoomPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('use-authenticated-route', static function (User $currentUser, User $attemptedUser) {
            return Auth('sanctum')->check() && $attemptedUser->id === $currentUser->id;
        });
    }
}

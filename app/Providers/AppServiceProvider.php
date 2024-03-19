<?php

namespace App\Providers;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $listen = [
        'App\Events\UserStore' => [
            'App\Listeners\UserStoreListener',
        ],
        'App\Events\UserUpdate' => [
            'App\Listeners\UserUpdateListener',
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

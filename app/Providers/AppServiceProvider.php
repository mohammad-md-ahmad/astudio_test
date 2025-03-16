<?php

namespace App\Providers;

use App\Contracts\AuthServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(AuthServiceInterface::class, AuthService::class);
        app()->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised();
        });

        Route::model('user', User::class);
    }
}

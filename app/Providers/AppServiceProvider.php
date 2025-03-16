<?php

namespace App\Providers;

use App\Contracts\AuthServiceInterface;
use App\Services\AuthService;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised();
        });
    }
}

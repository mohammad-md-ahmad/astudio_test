<?php

namespace App\Providers;

use App\Contracts\AttributeServiceInterface;
use App\Contracts\AuthServiceInterface;
use App\Contracts\ProjectServiceInterface;
use App\Contracts\ProjectUserServiceInterface;
use App\Contracts\TimesheetServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Models\Attribute;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use App\Services\AttributeService;
use App\Services\AuthService;
use App\Services\ProjectService;
use App\Services\ProjectUserService;
use App\Services\TimesheetService;
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
        app()->bind(ProjectServiceInterface::class, ProjectService::class);
        app()->bind(ProjectUserServiceInterface::class, ProjectUserService::class);
        app()->bind(TimesheetServiceInterface::class, TimesheetService::class);
        app()->bind(AttributeServiceInterface::class, AttributeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised();
        });

        // explicitly binding route parameters to models
        Route::model('user', User::class);
        Route::model('project', Project::class);
        Route::model('timesheet', Timesheet::class);
        Route::model('attribute', Attribute::class);
    }
}

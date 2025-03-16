<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    Route::controller(UserController::class)->name('users.')->group(function () {
        Route::get('/users/{user}', 'get')->name('get');
        Route::get('/users', 'getAll')->name('get-all');
        Route::post('/users', 'create')->name('create');
        Route::put('/users/{user}', 'update')->name('update');
        Route::delete('/users/{user}', 'delete')->name('delete');
    });

    Route::controller(ProjectController::class)->name('projects.')->group(function () {
        Route::get('/projects/{project}', 'get')->name('get');
        Route::get('/projects', 'getAll')->name('get-all');
        Route::post('/projects', 'create')->name('create');
        Route::put('/projects/{project}', 'update')->name('update');
        Route::delete('/projects/{project}', 'delete')->name('delete');
    });

    Route::controller(TimesheetController::class)->name('timesheets.')->group(function () {
        Route::get('/timesheets/{timesheet}', 'get')->name('get');
        Route::get('/timesheets', 'getAll')->name('get-all');
        Route::post('/timesheets', 'create')->name('create');
        Route::put('/timesheets/{timesheet}', 'update')->name('update');
        Route::delete('/timesheets/{timesheet}', 'delete')->name('delete');
    });
});

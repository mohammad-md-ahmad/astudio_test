<?php

use App\Http\Controllers\AuthController;
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
});

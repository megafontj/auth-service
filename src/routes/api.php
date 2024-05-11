<?php

use App\Http\Controllers\ApiV1\AuthController;
use App\Http\Controllers\ApiV1\UserController;
use App\Http\Middleware\OnlyGuestAccessMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->middleware(OnlyGuestAccessMiddleware::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('register',  'register');
        Route::post('login',  'login');
});

Route::apiResource('users', UserController::class);

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
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('auth/current', [AuthController::class, 'current'])->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);

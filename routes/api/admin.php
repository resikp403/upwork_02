<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->middleware('throttle:10,1')
    ->group(function () {
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });

Route::controller(DashboardController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('dashboard', 'dashboard');
    });

<?php

use App\Http\Controllers\Api\Client\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('auth/client')
    ->group(function () {
        Route::controller(DashboardController::class)
            ->group(function () {
                Route::get('dashboard', 'index');
                Route::get('dashboard/{id?}','show')->where(['id' => '[0-9]+']);
            });
    });
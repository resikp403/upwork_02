<?php

use App\Http\Controllers\Api\Freelancer\AuthController;
use App\Http\Controllers\Api\Freelancer\VerificationController;
use Illuminate\Support\Facades\Route;

Route::controller(VerificationController::class)
    ->middleware('throttle:10,1')
    ->group(function () {
        Route::post('verify', 'verify');
        Route::post('confirm', 'confirm');
    });

Route::controller(AuthController::class)
    ->middleware('throttle:10,1')
    ->group(function () {
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:customer_api');
    });

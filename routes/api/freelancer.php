<?php

use App\Http\Controllers\Api\Freelancer\AuthController;
use App\Http\Controllers\Api\Freelancer\DashboardController;
use App\Http\Controllers\Api\Freelancer\VerificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/freelancer')
    ->group(function () {
        Route::controller(VerificationController::class)
            ->middleware('throttle:10,1')
            ->group(function () {
                Route::post('verify', 'verify');
                Route::post('confirm', 'confirm');
            });

        Route::controller(AuthController::class)
            ->middleware('throttle:10,1')
            ->group(function () {
                Route::post('register', 'register');
                Route::post('login', 'login');
                Route::post('recover', 'recover');
                Route::post('logout', 'logout')->middleware('auth:sanctum');
            });

        Route::middleware('auth:sanctum')
            ->prefix('auth')
            ->group(function () {
                Route::controller(DashboardController::class)
                    ->group(function () {
                        Route::get('index', 'index');
                        Route::get('show/{id?}','show')->name('show')->where(['id' => '[0-9]+']);
                        Route::put('update/{id}', 'update')->name('update')->where(['id' => '[0-9]+']);
                        Route::delete('destroy/{id}', 'destroy')->name('destroy')->where(['id' => '[0-9]+']);
                        Route::post('filter', 'filter');
                    });
            });
            
    });

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::middleware('auth:sanctum')
            ->prefix('auth')
            ->group(function () {
                Route::controller(ProfileController::class)
                    ->group(function () {
                        Route::get('profiles','index');
                        Route::get('profiles/{id?}','show')->name('show')->where(['id' => '[0-9]+']);
                    });
            });


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

Route::middleware('auth:sanctum')
            ->prefix('auth/review')
            ->group(function () {
                Route::controller(ReviewController::class)
                    ->group(function () {
                        Route::get('index', 'index');
                        Route::get('show/{id}','show')->name('show')->where(['id' => '[0-9]+']);
                        Route::post('create','create');
                        Route::put('update/{id}', 'update')->name('update')->where(['id' => '[0-9]+']);
                        Route::delete('delete/{id}', 'destroy')->name('destroy')->where(['id' => '[0-9]+']);
                    });
            });
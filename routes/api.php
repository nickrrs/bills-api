<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        //Public Routes
        Route::post('login', [AuthController::class, 'login'])->name('v1.auth.login');
        Route::post('register', [AuthController::class, 'register'])->name('v1.auth.register');

        //Protected Routes
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('user', [AuthController::class, 'user'])->name('v1.auth.me');
            Route::post('logout', [AuthController::class, 'logout'])->name('v1.auth.logout');
        });
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::resource('categories', CategoryController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    });
});

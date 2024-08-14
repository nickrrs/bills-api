<?php

use App\Http\Controllers\API\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function (){
    Route::group(['prefix' => 'auth'], function () {
        //Public Routes
        Route::post('register', [AuthController::class, 'register'])->name('v1.auth.register');
    });
});



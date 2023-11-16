<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->prefix("/auth")
    ->group(function () {
        Route::post('/get-token', 'getToken');
        Route::post('/sign-up', 'signUp');
    });

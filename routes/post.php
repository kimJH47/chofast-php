<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)
    ->prefix("/post")
    ->group(function () {
        Route::post('', 'save')
            ->middleware("jwt-auth");
        Route::get('/{id}', 'findOne');
    });

Route::controller(PostController::class)
    ->prefix("/feed")
    ->group(function () {
        Route::get('', 'findFirstFeed');
        Route::get('/{lastId}', 'findByRecently');
    });


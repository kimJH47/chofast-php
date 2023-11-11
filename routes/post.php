<?php
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)
    ->prefix("/post")
    ->group(function () {
        Route::get('/{id}', 'findOne');
        Route::post('', 'save');
    });

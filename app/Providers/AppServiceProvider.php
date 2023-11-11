<?php

namespace App\Providers;

use App\Http\applications\PostService;
use App\Http\Controllers\PostController;
use App\Http\daos\PostDao;
use App\Http\daos\UserDao;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PostDao::class, function () {
            return new PostDao();
        });

        $this->app->singleton(UserDao::class, function () {
            return new UserDao();
        });

        $this->app->singleton(PostService::class, function (Application $application) {
            return new PostService($application->make(PostDao::class), $application->make(UserDao::class));
        });

        $this->app->singleton(PostController::class, function (Application $application) {
            return new PostController($application->make(PostService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

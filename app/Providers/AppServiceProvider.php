<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\User\UserInterface;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Schema;
use App\Services\Todo\TodoInterface;
use App\Services\Todo\TodoService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserInterface::class,
            UserService::class
        );

        $this->app->bind(
            TodoInterface::class,
            TodoService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}

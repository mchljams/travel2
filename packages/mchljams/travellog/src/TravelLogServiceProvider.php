<?php

namespace Mchljams\TravelLog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Mchljams\TravelLog\Exceptions\ApiHandler;

class TravelLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the custom API Exception Handler
        $this->app->bind(
            ExceptionHandler::class,
            ApiHandler::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load the package API Routes
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        // Load the package migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        // Load the package factories
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/Database/Factories');
    }
}

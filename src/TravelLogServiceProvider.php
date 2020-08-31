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
        // Publish a config file
        $configPath = __DIR__.'/../config/l5-swagger.php';
        $this->publishes([
            __DIR__.'/../config/l5-swagger.php' => config_path('l5-swagger.php'),
            __DIR__.'/../config/auth.php' => config_path('auth.php'),

        ], 'travellog');

        //Publish views from l5-swagger and cities data to storage
        $this->publishes([
            base_path() . '/vendor/darkaonline/l5-swagger/resources/views' => config('l5-swagger.paths.views'),
            __DIR__.'/../data/simplemaps_uscities_basicv1.6/uscities.csv' => storage_path('app/uscities.csv'),
        ], 'travellog');

        // Load the package API Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        // Load the package migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        // Load the package factories
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/Database/Factories');
    }
}

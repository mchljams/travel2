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
        /**
         * Do not forget to import them before using!
         */
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
        //
        include __DIR__.'/Routes/api.php';
    }
}

<?php

namespace Hardudev\ModuleMaker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Hardudev\ModuleMaker\Console\Commands\MakeModule;

class ModuleMakerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register the command so it can be used with Artisan.
        $this->commands([
            MakeModule::class,
        ]);

        // Optionally, you can add more bootstrapping here (e.g., publishing assets, routes, etc.)
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // You can register bindings or package services in this method.
    }
}

<?php

namespace Delosfei\Generator;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerScaffoldGenerator();
    }

    /**
     * Register the make:scaffold generator.
     *
     * @return void
     */
    private function registerScaffoldGenerator()
    {
        $this->app->singleton('command.larascaf.scaffold', function ($app) {
            return $app['Delosfei\Generator\Commands\MakeCodeCommand'];
        });

        $this->commands('command.larascaf.scaffold');
    }
}
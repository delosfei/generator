<?php

namespace Delosfei\Generator;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{


    public function boot()
    {
        $this->registerScaffoldGenerator();
        $this->registerServicesGenerator();
        $this->registerBaseGenerator();
    }


    public function register()
    {

    }


    private function registerScaffoldGenerator()
    {
        $this->app->singleton(
            'command.larascaf.scaffold',
            function ($app) {
                return $app['App\Console\Commands\MakeCodeCommand'];
            }
        );

        $this->commands('command.larascaf.scaffold');
    }

    private function registerServicesGenerator()
    {
        $this->app->singleton(
            'command.larascaf.services',
            function ($app) {
                return $app['App\Console\Commands\MakeServicesCommand'];
            }
        );

        $this->commands('command.larascaf.services');
    }

    private function registerBaseGenerator()
    {
        $this->app->singleton(
            'command.larascaf.module',
            function ($app) {
                return $app['App\Console\Commands\MakeModule'];
            }
        );

        $this->commands('command.larascaf.module');
    }

}

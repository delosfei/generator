<?php

namespace Delosfei\Generator;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{


	public function boot()
	{
        $this->registerScaffoldGenerator();
        $this->registerServicesGenerator();
	}


	public function register()
	{

	}


	private function registerScaffoldGenerator()
	{
		$this->app->singleton('command.larascaf.scaffold', function ($app) {
			return $app['Delosfei\Generator\Commands\MakeCodeCommand'];
		});

		$this->commands('command.larascaf.scaffold');
	}

    private function registerServicesGenerator()
    {
        $this->app->singleton('command.larascaf.services', function ($app) {
            return $app['Delosfei\Services\Commands\MakeServicesCommand'];
        });

        $this->commands('command.larascaf.services');
    }
}
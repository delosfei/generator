<?php

namespace Delosfei\Generator;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{


	public function boot()
	{
        $this->registerScaffoldGenerator();
        $this->registerServicesGenerator();
        $this->registerVueuiGenerator();
        $this->registerBaseGenerator();
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
            return $app['Delosfei\Generator\Commands\MakeServicesCommand'];
        });

        $this->commands('command.larascaf.services');
    }
    private function registerVueuiGenerator()
    {
        $this->app->singleton('command.larascaf.vueui', function ($app) {
            return $app['Delosfei\Generator\Commands\MakeVueuiCommand'];
        });

        $this->commands('command.larascaf.vueui');
    }
    private function registerBaseGenerator()
    {
        $this->app->singleton('command.larascaf.vueui', function ($app) {
            return $app['Delosfei\Generator\Commands\MakeVueuiCommand'];
        });

        $this->commands('command.larascaf.vueui');
    }
}
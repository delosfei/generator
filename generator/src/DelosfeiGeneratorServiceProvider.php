<?php

namespace Delosfei\Generator;

use Delosfei\Generator\Commands\API\APIControllerGeneratorCommand;
use Delosfei\Generator\Commands\API\APIGeneratorCommand;
use Delosfei\Generator\Commands\API\APIRequestsGeneratorCommand;
use Delosfei\Generator\Commands\APIScaffoldGeneratorCommand;
use Delosfei\Generator\Commands\Common\MigrationGeneratorCommand;
use Delosfei\Generator\Commands\Common\ModelGeneratorCommand;
use Delosfei\Generator\Commands\Publish\GeneratorPublishCommand;
use Delosfei\Generator\Commands\Publish\PublishLayoutCommand;
use Delosfei\Generator\Commands\Publish\PublishTemplateCommand;
use Delosfei\Generator\Commands\RollbackGeneratorCommand;
use Delosfei\Generator\Commands\Scaffold\ControllerGeneratorCommand;
use Delosfei\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use Delosfei\Generator\Commands\Scaffold\ViewsGeneratorCommand;
use Delosfei\Generator\Commands\Service\ServiceGeneratorCommand;
use Illuminate\Support\ServiceProvider;

class DelosfeiGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/generator.php';

        $this->publishes(
            [
                $configPath => config_path('delosfei/generator.php'),
            ]
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'delosfei.publish',
            function ($app) {
                return new GeneratorPublishCommand();
            }
        );

        $this->app->singleton(
            'delosfei.generator.path',
            function ($app) {
                return new APIGeneratorCommand();
            }
        );

        $this->app->singleton(
            'delosfei.scaffold',
            function ($app) {
                return new ScaffoldGeneratorCommand();
            }
        );

        $this->app->singleton(
            'delosfei.publish.layout',
            function ($app) {
                return new PublishLayoutCommand();
            }
        );

        $this->app->singleton(
            'delosfei.publish.templates',
            function ($app) {
                return new PublishTemplateCommand();
            }
        );

        $this->app->singleton(
            'delosfei.generator.path_scaffold',
            function ($app) {
                return new APIScaffoldGeneratorCommand();
            }
        );

        $this->app->singleton(
            'delosfei.migration',
            function ($app) {
                return new MigrationGeneratorCommand();
            }
        );

        $this->app->singleton(
            'delosfei.model',
            function ($app) {
                return new ModelGeneratorCommand();
            }
        );


        $this->app->singleton(
            'delosfei.generator.path.controller',
            function ($app) {
                return new APIControllerGeneratorCommand();
            }
        );

        $this->app->singleton(
            'delosfei.generator.path.requests',
            function ($app) {
                return new APIRequestsGeneratorCommand();
            }
        );


        $this->app->singleton(
            'delosfei.scaffold.requests',
            function ($app) {
                return new ServiceGeneratorCommand();
            }
        );

        $this->app->singleton(
            'delosfei.scaffold.views',
            function ($app) {
                return new ViewsGeneratorCommand();
            }
        );

        $this->app->singleton(
            'delosfei.rollback',
            function ($app) {
                return new RollbackGeneratorCommand();
            }
        );


        $this->app->singleton(
            'delosfei.service',
            function ($app) {
                return new ServiceGeneratorCommand();
            }
        );


        $this->commands(
            [
                'delosfei.publish',
                'delosfei.generator.path',
                'delosfei.scaffold',
                'delosfei.generator.path_scaffold',
                'delosfei.publish.layout',
                'delosfei.publish.templates',
                'delosfei.migration',
                'delosfei.model',
                'delosfei.generator.path.controller',
                'delosfei.generator.path.requests',
                'delosfei.scaffold.requests',
                'delosfei.scaffold.views',
                'delosfei.rollback',
                'delosfei.service',

            ]
        );
    }
}

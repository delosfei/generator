<?php

namespace Delosfei\Generator;

use Illuminate\Support\ServiceProvider;
use Delosfei\Generator\Commands\API\APIControllerGeneratorCommand;
use Delosfei\Generator\Commands\API\APIGeneratorCommand;
use Delosfei\Generator\Commands\API\APIRequestsGeneratorCommand;
use Delosfei\Generator\Commands\API\TestsGeneratorCommand;
use Delosfei\Generator\Commands\APIScaffoldGeneratorCommand;
use Delosfei\Generator\Commands\Common\MigrationGeneratorCommand;
use Delosfei\Generator\Commands\Common\ModelGeneratorCommand;
use Delosfei\Generator\Commands\Common\RepositoryGeneratorCommand;
use Delosfei\Generator\Commands\Publish\GeneratorPublishCommand;
use Delosfei\Generator\Commands\Publish\LayoutPublishCommand;
use Delosfei\Generator\Commands\Publish\PublishTemplateCommand;
use Delosfei\Generator\Commands\Publish\PublishUserCommand;
use Delosfei\Generator\Commands\RollbackGeneratorCommand;
use Delosfei\Generator\Commands\Scaffold\ControllerGeneratorCommand;
use Delosfei\Generator\Commands\Scaffold\RequestsGeneratorCommand;
use Delosfei\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use Delosfei\Generator\Commands\Scaffold\ViewsGeneratorCommand;

class DelosfeiGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/laravel_generator.php';

        $this->publishes([
            $configPath => config_path('delos/laravel_generator.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('delos.publish', function ($app) {
            return new GeneratorPublishCommand();
        });

        $this->app->singleton('delos.api', function ($app) {
            return new APIGeneratorCommand();
        });

        $this->app->singleton('delos.scaffold', function ($app) {
            return new ScaffoldGeneratorCommand();
        });

        $this->app->singleton('delos.publish.layout', function ($app) {
            return new LayoutPublishCommand();
        });

        $this->app->singleton('delos.publish.templates', function ($app) {
            return new PublishTemplateCommand();
        });

        $this->app->singleton('delos.api_scaffold', function ($app) {
            return new APIScaffoldGeneratorCommand();
        });

        $this->app->singleton('delos.migration', function ($app) {
            return new MigrationGeneratorCommand();
        });

        $this->app->singleton('delos.model', function ($app) {
            return new ModelGeneratorCommand();
        });

        $this->app->singleton('delos.repository', function ($app) {
            return new RepositoryGeneratorCommand();
        });

        $this->app->singleton('delos.api.controller', function ($app) {
            return new APIControllerGeneratorCommand();
        });

        $this->app->singleton('delos.api.requests', function ($app) {
            return new APIRequestsGeneratorCommand();
        });

        $this->app->singleton('delos.api.tests', function ($app) {
            return new TestsGeneratorCommand();
        });

        $this->app->singleton('delos.scaffold.controller', function ($app) {
            return new ControllerGeneratorCommand();
        });

        $this->app->singleton('delos.scaffold.requests', function ($app) {
            return new RequestsGeneratorCommand();
        });

        $this->app->singleton('delos.scaffold.views', function ($app) {
            return new ViewsGeneratorCommand();
        });

        $this->app->singleton('delos.rollback', function ($app) {
            return new RollbackGeneratorCommand();
        });

        $this->app->singleton('delos.publish.user', function ($app) {
            return new PublishUserCommand();
        });

        $this->commands([
            'delos.publish',
            'delos.api',
            'delos.scaffold',
            'delos.api_scaffold',
            'delos.publish.layout',
            'delos.publish.templates',
            'delos.migration',
            'delos.model',
            'delos.repository',
            'delos.api.controller',
            'delos.api.requests',
            'delos.api.tests',
            'delos.scaffold.controller',
            'delos.scaffold.requests',
            'delos.scaffold.views',
            'delos.rollback',
            'delos.publish.user',
        ]);
    }
}

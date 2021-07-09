<?php

namespace Delosfei\Generator\Commands;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\API\APIControllerGenerator;
use Delosfei\Generator\Generators\API\APIRequestGenerator;
use Delosfei\Generator\Generators\API\APIResourceGenerator;
use Delosfei\Generator\Generators\API\APIRoutesGenerator;
use Delosfei\Generator\Generators\FactoryGenerator;
use Delosfei\Generator\Generators\MigrationGenerator;
use Delosfei\Generator\Generators\ModelGenerator;
use Delosfei\Generator\Generators\Scaffold\ControllerGenerator;
use Delosfei\Generator\Generators\Scaffold\RequestGenerator;
use Delosfei\Generator\Generators\Scaffold\RoutesGenerator;
use Delosfei\Generator\Generators\Scaffold\ViewGenerator;
use Delosfei\Generator\Generators\SeederGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RollbackGeneratorCommand extends Command
{
    /**
     * The command Data.
     *
     * @var CommandData
     */
    public $commandData;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ds:rollback';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback a full CRUD API and Scaffold for given model';

    /**
     * @var Composer
     */
    public $composer;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->composer = app()['composer'];
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        if (!in_array(
            $this->argument('type'),
            [
                CommandData::$COMMAND_TYPE_API,
                CommandData::$COMMAND_TYPE_SCAFFOLD,
                CommandData::$COMMAND_TYPE_API_SCAFFOLD,
            ]
        )) {
            $this->error('invalid rollback type');
        }

        $this->commandData = new CommandData($this, $this->argument('type'));
        $this->commandData->config->mName = $this->commandData->modelName = ucfirst($this->argument('model'));

        $this->commandData->config->init($this->commandData, ['tableName', 'prefix', 'plural', 'views']);

        $views = $this->commandData->getOption('views');
        if (!empty($views)) {
            $views = explode(',', $views);
            $viewGenerator = new ViewGenerator($this->commandData);
            $viewGenerator->rollback($views);

            $this->commandData->commandInfo('Generating autoload files');
            $this->composer->dumpOptimized();

            return;
        }

        $migrationGenerator = new MigrationGenerator($this->commandData);
        $migrationGenerator->rollback();

        $modelGenerator = new ModelGenerator($this->commandData);
        $modelGenerator->rollback();

        $requestGenerator = new APIRequestGenerator($this->commandData);
        $requestGenerator->rollback();

        $controllerGenerator = new APIControllerGenerator($this->commandData);
        $controllerGenerator->rollback();

        $routesGenerator = new APIRoutesGenerator($this->commandData);
        $routesGenerator->rollback();

        $requestGenerator = new RequestGenerator($this->commandData);
        $requestGenerator->rollback();

        $controllerGenerator = new ControllerGenerator($this->commandData);
        $controllerGenerator->rollback();

        $routeGenerator = new RoutesGenerator($this->commandData);
        $routeGenerator->rollback();

        $resourceGenerator = new APIResourceGenerator($this->commandData);
        $resourceGenerator->rollback();

        $factoryGenerator = new FactoryGenerator($this->commandData);
        $factoryGenerator->rollback();

        $seederGenerator = new SeederGenerator($this->commandData);
        $seederGenerator->rollback();

        $viewGenerator = new ViewGenerator($this->commandData);
        $viewGenerator->rollback();

        $this->commandData->commandInfo('Generating autoload files');
        $this->composer->dumpOptimized();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['tableName', null, InputOption::VALUE_REQUIRED, 'Table Name'],
            ['prefix', null, InputOption::VALUE_REQUIRED, 'Prefix for all files'],
            ['plural', null, InputOption::VALUE_REQUIRED, 'Plural Model name'],
            ['views', null, InputOption::VALUE_REQUIRED, 'Views to rollback'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'Singular Model name'],
            ['type', InputArgument::REQUIRED, 'Rollback type: (api / scaffold / api_scaffold)'],
        ];
    }
}

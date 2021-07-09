<?php

namespace Delosfei\Generator\Commands;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\API\APIControllerGenerator;
use Delosfei\Generator\Generators\API\APIPolicyGenerator;
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
use Delosfei\Generator\Utils\FileUtil;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BaseCommand extends Command
{
    /**
     * The command Data.
     *
     * @var CommandData
     */
    public $commandData;

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

    public function handle()
    {
        $this->commandData->modelName = ucfirst($this->argument('model'));
        $this->commandData->initCommandData();
        $this->commandData->getFields();
    }

    public function generateCommonItems()
    {
        if (!$this->commandData->getOption('fromTable') and !$this->isSkip('migration')) {
            $migrationGenerator = new MigrationGenerator($this->commandData);
            $migrationGenerator->generate();
        }

        if (!$this->isSkip('model')) {
            $modelGenerator = new ModelGenerator($this->commandData);
            $modelGenerator->generate();
        }

        if ($this->commandData->getOption('factory')) {
            $factoryGenerator = new FactoryGenerator($this->commandData);
            $factoryGenerator->generate();
        }

        if ($this->commandData->getOption('seeder')) {
            $seederGenerator = new SeederGenerator($this->commandData);
            $seederGenerator->generate();
        }

//        if ($this->commandData->getOption('observer')) {
//            $observerGenerator = new ObserverGenerator($this->commandData);
//            $observerGenerator->generate();
//        }


    }

    public function generateAPIItems()
    {
        if (!$this->isSkip('requests') and !$this->isSkip('api_requests')) {
            $requestGenerator = new APIRequestGenerator($this->commandData);
            $requestGenerator->generate();
        }

        if (!$this->isSkip('controllers') and !$this->isSkip('api_controller')) {
            $controllerGenerator = new APIControllerGenerator($this->commandData);
            $controllerGenerator->generate();
        }

        if (!$this->isSkip('routes') and !$this->isSkip('api_routes')) {
            $routesGenerator = new APIRoutesGenerator($this->commandData);
            $routesGenerator->generate();
        }

        if (!$this->isSkip('resources') and !$this->isSkip('api_resources')) {
            $apiResourceGenerator = new APIResourceGenerator($this->commandData);
            $apiResourceGenerator->generate();
        }

        if (!$this->isSkip('policies') and !$this->isSkip('api_policies')) {
            $apiPolicyGenerator = new APIPolicyGenerator($this->commandData);
            $apiPolicyGenerator->generate();
        }


    }

    public function generateScaffoldItems()
    {
        if (!$this->isSkip('requests') and !$this->isSkip('scaffold_requests')) {
            $requestGenerator = new RequestGenerator($this->commandData);
            $requestGenerator->generate();
        }

        if (!$this->isSkip('controllers') and !$this->isSkip('scaffold_controller')) {
            $controllerGenerator = new ControllerGenerator($this->commandData);
            $controllerGenerator->generate();
        }

        if (!$this->isSkip('views')) {
            $viewGenerator = new ViewGenerator($this->commandData);
            $viewGenerator->generate();
        }

        if (!$this->isSkip('routes') and !$this->isSkip('scaffold_routes')) {
            $routeGenerator = new RoutesGenerator($this->commandData);
            $routeGenerator->generate();
        }

    }

    public function performPostActions($runMigration = false)
    {
        if ($this->commandData->getOption('save')) {
            $this->saveSchemaFile();
        }

        if ($runMigration) {
            if ($this->commandData->getOption('forceMigrate')) {
                $this->runMigration();
            } elseif (!$this->commandData->getOption('fromTable') and !$this->isSkip('migration')) {
                $requestFromConsole = php_sapi_name() == 'cli';
                if ($this->commandData->getOption('jsonFromGUI') && $requestFromConsole) {
                    $this->runMigration();
                } elseif ($requestFromConsole && $this->confirm("\nDo you want to migrate database? [y|N]", false)) {
                    $this->runMigration();
                }
            }
        }

        if (!$this->isSkip('dump-autoload')) {
            $this->info('Generating autoload files');
            $this->composer->dumpOptimized();
        }
    }

    public function runMigration()
    {
        $migrationPath = config('delosfei.generator.path.migration', database_path('migrations/'));
        $path = Str::after($migrationPath, base_path()); // get path after base_path
        $this->call('migrate', ['--path' => $path, '--force' => true]);

        return true;
    }

    public function isSkip($skip)
    {
        if ($this->commandData->getOption('skip')) {
            return in_array($skip, (array)$this->commandData->getOption('skip'));
        }

        return false;
    }

    public function performPostActionsWithMigration()
    {
        $this->performPostActions(true);
    }

    private function saveSchemaFile()
    {
        $fileFields = [];

        foreach ($this->commandData->fields as $field) {

            $field->validations = implode("|", array_unique(explode("|", $field->validations)));

            $fileFields[] = [
                'name' => $field->name,
                'title' => $field->title,
                'dbType' => $field->dbInput,
                'htmlType' => $field->htmlInput,
                'validations' => $field->validations,
                'searchable' => $field->isSearchable,
                'fillable' => $field->isFillable,
                'primary' => $field->isPrimary,
                'inForm' => $field->inForm,
                'inIndex' => $field->inIndex,
                'inView' => $field->inView,
            ];
        }

        foreach ($this->commandData->relations as $relation) {
            $fileFields[] = [
                'type' => 'relation',
                'relation' => $relation->type.','.implode(',', $relation->inputs),
            ];
        }

        $path = config('delosfei.generator.path.schema_files', resource_path('model_schemas/'));

        $fileName = $this->commandData->modelName.'.json';

        if (file_exists($path.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }
        FileUtil::createFile($path, $fileName, json_encode($fileFields, JSON_UNESCAPED_UNICODE));
        $this->commandData->commandComment('+ '.$path.$fileName);
    }


    /**
     * @param $fileName
     * @param string $prompt
     *
     * @return bool
     */
    public function confirmOverwrite($fileName, $prompt = '')
    {
        $prompt = (empty($prompt))
            ? $fileName.' already exists. Do you want to overwrite it? [y|N]'
            : $prompt;

        return $this->confirm($prompt, false);
    }


    public function createFileAndShowInfo($path, $fileName, $templateData, $info = null)
    {
        if (file_exists($path.$fileName) && !$this->confirmOverwrite($fileName)) {
            return false;
        }
        FileUtil::createFile($path, $fileName, $templateData);
        $path = Str::after($path, base_path());

        return $this->comment('+ '.$path.$fileName.$info);
    }

    public function deleteFileAndShowInfoIfExists($path, $fileName)
    {
        if (file_exists($path.$fileName)) {
            FileUtil::deleteFile($path, $fileName);
            $path = Str::after($path, base_path());

            return $this->comment('- '.$path.$fileName);
        }

        return false;
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['fieldsFile', null, InputOption::VALUE_REQUIRED, 'Fields input as json file'],
            ['jsonFromGUI', null, InputOption::VALUE_REQUIRED, 'Direct Json string while using GUI interface'],
            ['plural', null, InputOption::VALUE_REQUIRED, 'Plural Model name'],
            ['tableName', null, InputOption::VALUE_REQUIRED, 'Table Name'],
            ['fromTable', null, InputOption::VALUE_NONE, 'Generate from existing table'],
            ['ignoreFields', null, InputOption::VALUE_REQUIRED, 'Ignore fields while generating from table'],
            ['save', null, InputOption::VALUE_NONE, 'Save model schema to file'],
            ['primary', null, InputOption::VALUE_REQUIRED, 'Custom primary key'],
            ['prefix', null, InputOption::VALUE_REQUIRED, 'Prefix for all files'],
            ['paginate', null, InputOption::VALUE_REQUIRED, 'Pagination for index.blade.php'],
            [
                'skip',
                null,
                InputOption::VALUE_REQUIRED,
                'Skip Specific Items to Generate (migration,model,controllers,api_controller,scaffold_controller,policy,requests,api_requests,scaffold_requests,routes,api_routes,scaffold_routes,views,dump-autoload)',
            ],
            ['datatables', null, InputOption::VALUE_REQUIRED, 'Override datatables settings'],
            ['views', null, InputOption::VALUE_REQUIRED, 'Specify only the views you want generated: index,create,edit,show'],
            ['relations', null, InputOption::VALUE_NONE, 'Specify if you want to pass relationships for fields'],
            ['softDelete', null, InputOption::VALUE_NONE, 'Soft Delete Option'],
            ['forceMigrate', null, InputOption::VALUE_NONE, 'Specify if you want to run migration or not'],
            ['factory', null, InputOption::VALUE_NONE, 'To generate factory'],
            ['seeder', null, InputOption::VALUE_NONE, 'To generate seeder'],
            ['observer', null, InputOption::VALUE_REQUIRED, 'To generate observer'],
            ['connection', null, InputOption::VALUE_REQUIRED, 'Specify connection name'],
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
        ];
    }
}

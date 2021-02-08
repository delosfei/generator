<?php

namespace Delosfei\Generator\Commands;

use Delosfei\Generator\Makes\MakeFormRequest;
use Delosfei\Generator\Makes\MakeLayout;
use Delosfei\Generator\Makes\MakeMigration;
use Delosfei\Generator\Makes\MakeModel;
use Delosfei\Generator\Makes\MakeModelObserver;
use Delosfei\Generator\Makes\MakeRoute;
use Delosfei\Generator\Makes\MakerTrait;
use Delosfei\Generator\Makes\MakeView;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Input;
use Delosfei\Generator\Makes\MakePolicy;
use Delosfei\Generator\Makes\MakeSeed;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Delosfei\Generator\Makes\MakeController;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeCodeCommand extends Command
{
    use MakerTrait;

    protected $name = 'ds:code';
    protected $description = '新建模块应用';
    protected $meta;
    protected $files;
    private $composer;
    private $nameModel = "";


    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = app()['composer'];
    }


    public function handle()
    {
        $header = "scaffolding: {$this->getObjName("Name")}";
        $footer = str_pad('', strlen($header), '-');
        $dump = str_pad('>DUMP AUTOLOAD<', strlen($header), ' ', STR_PAD_BOTH);

        $this->line("\n----------- $header -----------\n");
        $this->makeMeta();
        $this->makeMigration();
        $this->makeSeed();
        $this->makeModel();
        $this->makeController();
        $this->makeFormRequest();
        $this->makeModelObserver();
        $this->makePolicy();
        $this->makeRoute();
//        // $this->makeLocalization(); //ToDo - implement in future version
        $this->makeViews();
        $this->makeViewLayout();

        // $this->call('migrate');
        Artisan::call("migrate");

        $this->line("\n----------- $footer -----------");
        $this->comment("----------- $dump -----------");

        $this->composer->dumpAutoloads();

    }

    protected function getArguments()
    {
        return
            [
                ['name', InputArgument::REQUIRED, 'The name of the model. (Ex: Post)'],
            ];
    }

    protected function getOptions()
    {
        return
            [
                [
                    'schema',
                    's',
                    InputOption::VALUE_REQUIRED,
                    'Schema to generate scaffold files. (Ex: --schema="title:string")',
                    null,
                ],
                [
                    'ui',
                    'ui',
                    InputOption::VALUE_OPTIONAL,
                    'UI Framework to generate scaffold. (Default bs4 - bootstrap 4)',
                    'bs4',
                ],
                [
                    'validator',
                    'a',
                    InputOption::VALUE_OPTIONAL,
                    'Validators to generate scaffold files. (Ex: --validator="title:required")',
                    null,
                ],
                [
                    'localization',
                    'l',
                    InputOption::VALUE_OPTIONAL,
                    'Localizations to generate scaffold files. (Ex. --localization="key:value")',
                    null,
                ],
                [
                    'lang',
                    'b',
                    InputOption::VALUE_OPTIONAL,
                    'Language for Localization (Ex. --lang="en")',
                    null,
                ],
                [
                    'form',
                    'f',
                    InputOption::VALUE_OPTIONAL,
                    'Use Illumintate/Html Form facade to generate input fields',
                    false,
                ],
                [
                    'prefix',
                    'p',
                    InputOption::VALUE_OPTIONAL,
                    'Generate schema with prefix',
                    false,
                ],
            ];
    }

    protected function makeMeta()
    {

        $this->meta['action'] = 'create';
        $this->meta['var_name'] = $this->getObjName("name");
        $this->meta['table'] = $this->getObjName("names");//obsole to
        $this->meta['namespace_name_app'] = $this->getObjName('namespace_name_app');
        $this->meta['namespace_name_gen'] = $this->getObjName('namespace_name_gen');
        $this->meta['namespace_path_app'] = $this->getObjName('namespace_path_app');
        $this->meta['Model'] = $this->getObjName('Name');
        $this->meta['Models'] = $this->getObjName('Names');
        $this->meta['model'] = $this->getObjName('name');
        $this->meta['models'] = $this->getObjName('names');
        $this->meta['ModelMigration'] = "Create{$this->meta['Models']}Table";

        $this->meta['ui'] = $this->option('ui');
        $this->meta['schema'] = $this->option('schema');
        $this->meta['prefix'] = ($prefix = $this->option('prefix')) ? "$prefix." : "";
    }

    protected function makeMigration()
    {
        new MakeMigration($this, $this->files);
    }


    private function makeSeed()
    {
        new MakeSeed($this, $this->files);
    }

    protected function makeModel()
    {
        new MakeModel($this, $this->files);
    }


    private function makeController()
    {
        new MakeController($this, $this->files);
    }

    private function makeFormRequest()
    {
        new MakeFormRequest($this, $this->files);
    }


    private function makeModelObserver()
    {
        new MakeModelObserver($this, $this->files);
    }


    private function makePolicy()
    {
        new MakePolicy($this, $this->files);
    }

    private function makeRoute()
    {
        new MakeRoute($this, $this->files);
    }

    private function makeViews()
    {
        new MakeView($this, $this->files);
    }

    private function makeViewLayout()
    {
        new MakeLayout($this, $this->files);
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function getObjName($config = 'Name')
    {
        $names = [];
        $args_name = $this->argument('name');

        if (strstr($args_name, '/')) {
            $ex = explode('/', $args_name);
            //模块名称
            $Module_name = $ex['0'];
            //Edu
            $names['Module'] = \Str::singular(ucfirst($Module_name));
            //edu
            $names['module'] = \Str::singular(strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $args_name)));
            //得模型名称
            $args_name = $ex[count($ex) - 1];
            // Article
            $names['Name'] = \Str::singular(ucfirst($args_name));
            // Articles
            $names['Names'] = \Str::plural(ucfirst($args_name));
            // articles
            $names['names'] = \Str::plural(strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $args_name)));
            // article
            $names['name'] = \Str::singular(strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $args_name)));
            //命名空间
            // Modules/Edu/
            $names['namespace_name_app'] = "Modules/".$names['Module']."/";
            $names['namespace_name_gen'] = "Modules/".$names['Module']."/";
            // Modules\Edu\
            $names['namespace_path_app'] = "Modules\\".$names['Module']."\\";

            $names['views_path_gen'] = $names['namespace_name_gen']."vue/views/";

        } else {
            // Article
            $names['Name'] = \Str::singular(ucfirst($args_name));
            // Articles
            $names['Names'] = \Str::plural(ucfirst($args_name));
            // articles
            $names['names'] = \Str::plural(strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $args_name)));
            // article
            $names['name'] = \Str::singular(strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $args_name)));

            $names['namespace_name_app'] = './app/';
            $names['namespace_name_gen'] = './';
            $names['namespace_path_app'] = 'App\\';
            $names['views_path_gen'] = $names['namespace_name_gen'].'resources/views/';
        }
        $names['views_path'] = $names['views_path_gen'].$names['name'].'/';


        if (!isset($names[$config])) {
            throw new \Exception("Position name is not found");
        };

        return $names[$config];
    }
}

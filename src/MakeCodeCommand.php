<?php

namespace App\Console\Commands;

use App\Console\Makes\Code\MakeController;
use App\Console\Makes\Code\MakeFormRequest;
use App\Console\Makes\Code\MakeMigration;
use App\Console\Makes\Code\MakeModel;
use App\Console\Makes\Code\MakeModelObserver;
use App\Console\Makes\Code\MakePolicy;
use App\Console\Makes\Code\MakeResource;
use App\Console\Makes\Code\MakeRoute;
use App\Console\Makes\Code\MakerTrait;
use App\Console\Makes\Code\MakeSeed;
use App\Console\Makes\Code\MakeView;
use App\Console\Makes\Code\MakeLayout;
use App\Console\Migrations\SchemaParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;
use Nwidart\Modules\Facades\Module;

class MakeCodeCommand extends Command
{
    use MakerTrait;

    protected $signature = 'ds:code  {name : the name of model. (Ex:site)}
                                     {cname="模型名称" : the Chinese name of model}
                                     {--d|dirname=default : the name of parent dir and layout. (Ex:system)}
                                     {--M|module= : the name of module. (Ex:Edu)}
                                     {--s|schema= : Schema to generate scaffold files. (Ex: --schema="title:string")}
                                     {--ui=vue : UI Framework to generate scaffold. (Default vue)}
                                     {--a|validator : Validators to generate scaffold files. (Ex: --validator="title:required")}
                                     {--l|localization : Localizations to generate scaffold files. (Ex. --localization="key:value")}
                                     {--b|lang : Language for Localization (Ex. --lang="en")}
                                     {--f|form= : Use Illuminate/Html Form facade to generate input fields}
                                     {--p|prefix= : Generate schema with prefix}
                                     ';

    protected $description = '生成结构代码';
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


    /**
     * @throws \Exception
     */
    public function handle()
    {
        $header = "scaffolding: {$this->getObjName("Name")}";
        $footer = str_pad('', strlen($header), '-');
        $dump = str_pad('>DUMP AUTOLOAD<', strlen($header), ' ', STR_PAD_BOTH);

        $this->line("\n----------- $header -----------\n");
        $this->makeMeta();
//        $this->makeMigration();
        $this->makeSeed();
//        $this->makeModel();
//        $this->makeController();
//        $this->makeFormRequest();
//        $this->makeModelObserver();
//        $this->makePolicy();
//        $this->makeResource();
//        $this->makeRoute();
//        // $this->makeLocalization(); //ToDo - implement in future version
//        $this->info("table:".print_r((new SchemaParser)->parse($this->meta['schema'])));
//        $this->info(print_r($this->meta));
//
//        (new SchemaParser)->parse($this->meta['schema']);
        $this->makeViewLayout();
        $this->makeViews();

        // $this->call('migrate');
//        Artisan::call("migrate");

        $this->line("\n----------- $footer -----------");
        $this->comment("----------- $dump -----------");
//        $this->composer->dumpAutoloads();
    }

    /**
     * @throws \Exception
     */
    protected function makeMeta()
    {
        $this->meta['action'] = 'create';
        $this->meta['var_name'] = $this->getObjName("name");
        $this->meta['cname'] = $this->getObjName("cname");
        $this->meta['table'] = $this->getObjName("table");
        $this->meta['Table'] = $this->getObjName("Table");
        $this->meta['namespace_name_app'] = $this->getObjName('namespace_name_app');
        $this->meta['namespace_name_gen'] = $this->getObjName('namespace_name_gen');
        $this->meta['namespace_name_model'] = $this->getObjName('namespace_name_model');
        $this->meta['namespace_path_app'] = $this->getObjName('namespace_path_app');
        $this->meta['namespace_path_model'] = $this->getObjName('namespace_path_model');
        $this->meta['namespace_database'] = $this->getObjName('namespace_database');
        $this->meta['Model'] = $this->getObjName('Name');
        $this->meta['Models'] = $this->getObjName('Names');
        $this->meta['model'] = $this->getObjName('name');
        $this->meta['models'] = $this->getObjName('names');
        $this->meta['Module'] = $this->getObjName('Module');
        $this->meta['ModelMigration'] = $this->getObjName('ModelMigration');
        $this->meta['database_path'] = $this->getObjName('database_path');
        $this->meta['seeder_name'] = $this->getObjName('seeder_name');
        $this->meta['name'] = $this->getObjName('name');
        $this->meta['names'] = $this->getObjName('names');
        $this->meta['dirname'] = $this->getObjName('dirname');
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

    private function makeResource()
    {
        new MakeResource($this, $this->files);
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

    /**
     * @throws \Exception
     */
    public function getObjName($config = 'Name')
    {
        $names = [];
        $args_name = $this->argument('name');
        $names['cname'] = $this->argument('cname');

        // Article
        $names['Name'] = \Str::singular(ucfirst($args_name));
        // Articles
        $names['Names'] = \Str::plural(ucfirst($args_name));
        // articles
        $names['names'] = \Str::plural(strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $args_name)));
        // article
        $names['name'] = \Str::singular(strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $args_name)));

        //
        $names['Prefix'] = ($prefix = $this->option('prefix')) ? ucfirst($prefix) : "";

        $names['prefix'] = ($prefix = $this->option('prefix')) ? strtolower($prefix) : "";

        //
        $names['Dirname'] = ($dirname = $this->option('dirname')) ? ucfirst($dirname) : "";

        $names['dirname'] = ($dirname = $this->option('dirname')) ? strtolower($dirname) : "";

        if ($this->option('module')) {
            $opts_module_name = $this->option('module');
            $names['Module'] = ucfirst($opts_module_name);
            $names['module'] = strtolower($opts_module_name);
            //如果模块不存在，则建立
            if (!Module::find($names['Module'])) {
                Artisan::call("module:make {$names['Module']}");
            }
            //命名空间
            // Modules/Edu/
            $names['namespace_name_app'] = config('modules.paths.modules').'/'.$names['Module']."/";
            $names['namespace_name_gen'] = config('modules.paths.modules').'/'.$names['Module']."/";
            //
            $names['namespace_name_model'] = config('modules.paths.modules').'/'.$names['Module']."/"."Entities"."/";
            // Modules\Edu\
            $names['namespace_path_app'] = config('modules.namespace')."\\".$names['Module']."\\";
            $names['namespace_path_model'] = $names['namespace_path_app']."Entities";
            // Modules\Edu\Database\
            $names['namespace_database'] = config('modules.namespace')."\\".$names['Module']."\\Database\\";
            $names['table'] = $names['module']."_".$names['names'];
            $names['Table'] = $names['Module'].$names['Names'];
            $names['database_path'] = $names['namespace_name_gen'].'Database/';
        } else {
            $names['Module'] = '';
            $names['module'] = '';
            $names['namespace_name_app'] = './app/';
            $names['namespace_name_gen'] = './';
            $names['namespace_name_model'] = './app/Models/';
            $names['namespace_path_app'] = 'App\\';
            $names['namespace_path_model'] = $names['namespace_path_app']."Models";
            $names['namespace_database'] = 'Database\\';
            $names['table'] = $names['prefix'] ? $names['prefix'].'_'.$names['names'] : $names['names'];
            $names['Table'] = $names['Prefix'] ? $names['Prefix'].$names['Names'] : $names['Names'];
            $names['database_path'] = $names['namespace_name_gen'].'database/';
        }

        $names['ModelMigration'] = "Create{$names['Table']}Table";
        $names['views_path'] = "";
        $names['seeder_name'] = $names['Module'].'DatabaseSeeder.php';

        if (!isset($names[$config])) {
            throw new \Exception("Position name is not found");
        };

        return $names[$config];
    }
}

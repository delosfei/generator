<?php

namespace Delosfei\Generator\Common;

use Illuminate\Support\Str;

class GeneratorConfig
{
    /* Namespace variables */
    public $nsApp;
    public $nsRepository;
    public $nsModel;
    public $nsDataTables;
    public $nsModelExtend;

    public $nsSeeder;
    public $nsFactory;

    public $nsApiController;
    public $nsApiResource;
    public $nsApiRequest;

    public $nsPolicy;
    public $nsPolicyBase;
    public $nsRequest;
    public $nsRequestBase;
    public $nsController;
    public $nsBaseController;


    /* Path variables */
    public $pathModel;
    public $pathDataTables;
    public $pathFactory;
    public $pathSeeder;
    public $pathDatabaseSeeder;
    public $pathViewProvider;

    public $pathApiController;
    public $pathApiResource;
    public $pathApiRequest;
    public $pathApiRoutes;

    public $pathController;
    public $pathRequest;
    public $pathPolicy;
    public $pathRoutes;
    public $pathViews;
    public $pathAssets;

    /* Model Names */
    public $mName;
    public $mPlural;
    public $mCamel;
    public $mCamelPlural;
    public $mSnake;
    public $mSnakePlural;
    public $mDashed;
    public $mDashedPlural;
    public $mSlash;
    public $mSlashPlural;
    public $mHuman;
    public $mHumanPlural;

    public $connection = '';

    /* Generator Options */
    public $options;

    /* Prefixes */
    public $prefixes;

    /** @var CommandData */
    private $commandData;

    /* Command Options */
    public static $availableOptions = [
        'fieldsFile',
        'jsonFromGUI',
        'tableName',
        'fromTable',
        'ignoreFields',
        'save',
        'primary',
        'prefix',
        'paginate',
        'skip',
        'datatables',
        'views',
        'relations',
        'plural',
        'softDelete',
        'forceMigrate',
        'factory',
        'seeder',
        'resources',
        'connection',
    ];

    public $tableName;

    /** @var string */
    protected $primaryName;

    /* Generator AddOns */
    public $addOns;


    public function init(CommandData &$commandData, $options = null)
    {
        if (!empty($options)) {
            self::$availableOptions = $options;
        }

        $this->mName = $commandData->modelName;

        $this->prepareAddOns();
        $this->prepareOptions($commandData);
        $this->prepareModelNames();
        $this->preparePrefixes();
        $this->loadPaths();
        $this->prepareTableName();
        $this->preparePrimaryName();
        $this->loadNamespaces($commandData);
        $commandData = $this->loadDynamicVariables($commandData);
        $this->commandData = &$commandData;
    }

    public function loadNamespaces(CommandData &$commandData)
    {
        $prefix = $this->prefixes['ns'];

        if (!empty($prefix)) {
            $prefix = '\\'.$prefix;
        }

        $this->nsApp = $commandData->commandObj->getLaravel()->getNamespace();
        $this->nsApp = substr($this->nsApp, 0, strlen($this->nsApp) - 1);
        $this->nsModel = config('delosfei.generator.namespace.model', 'App\Models').$prefix;
        if (config('delosfei.generator.ignore_model_prefix', false)) {
            $this->nsModel = config('delosfei.generator.namespace.model', 'App\Models');
        }
        $this->nsSeeder = config('delosfei.generator.namespace.seeder', 'Database\Seeders').$prefix;
        $this->nsFactory = config('delosfei.generator.namespace.factory', 'Database\Factories').$prefix;
        $this->nsDataTables = config('delosfei.generator.namespace.datatables', 'App\DataTables').$prefix;
        $this->nsModelExtend = config(
            'delosfei.generator.model_extend_class',
            'Illuminate\Database\Eloquent\Model'
        );

        $this->nsApiController = config(
                'delosfei.generator.namespace.api_controller',
                'App\Http\Controllers\API'
            ).$prefix;
        $this->nsApiResource = config(
                'delosfei.generator.namespace.api_resource',
                'App\Http\Resources'
            ).$prefix;
        $this->nsApiRequest = config('delosfei.generator.namespace.api_request', 'App\Http\Requests\API').$prefix;

        $this->nsPolicy = config('delosfei.generator.namespace.policy', 'App\Policies').$prefix;
        $this->nsPolicyBase = config('delosfei.generator.namespace.policy', 'App\Policies');

        $this->nsRequest = config('delosfei.generator.namespace.request', 'App\Http\Requests').$prefix;
        $this->nsRequestBase = config('delosfei.generator.namespace.request', 'App\Http\Requests');
        $this->nsBaseController = config('delosfei.generator.namespace.controller', 'App\Http\Controllers');
        $this->nsController = config('delosfei.generator.namespace.controller', 'App\Http\Controllers').$prefix;

    }

    public function loadPaths()
    {
        $prefix = $this->prefixes['path'];

        if (!empty($prefix)) {
            $prefix .= '/';
        }

        $viewPrefix = $this->prefixes['view'];

        if (!empty($viewPrefix)) {
            $viewPrefix .= '/';
        }

        $this->pathModel = config('delosfei.generator.path.model', app_path('Models/')).$prefix;
        if (config('delosfei.generator.ignore_model_prefix', false)) {
            $this->pathModel = config('delosfei.generator.path.model', app_path('Models/'));
        }

        $this->pathDataTables = config('delosfei.generator.path.datatables', app_path('DataTables/')).$prefix;

        $this->pathApiController = config(
                'delosfei.generator.path.api_controller',
                app_path('Http/Controllers/API/')
            ).$prefix;

        $this->pathApiResource = config(
                'delosfei.generator.path.api_resource',
                app_path('Http/Resources/')
            ).$prefix;

        $this->pathApiRequest = config(
                'delosfei.generator.path.api_request',
                app_path('Http/Requests/API/')
            ).$prefix;

        $this->pathApiRoutes = config('delosfei.generator.path.api_routes', base_path('routes/api.php'));


        $this->pathController = config(
                'delosfei.generator.path.controller',
                app_path('Http/Controllers/')
            ).$prefix;

        $this->pathRequest = config('delosfei.generator.path.request', app_path('Http/Requests/')).$prefix;

        $this->pathRoutes = config('delosfei.generator.path.routes', base_path('routes/web.php'));
        $this->pathFactory = config('delosfei.generator.path.factory', database_path('factories/'));

        $this->pathViews = config(
                'delosfei.generator.path.views',
                resource_path('views/')
            ).$viewPrefix.$this->mSnakePlural.'/';

        $this->pathAssets = config(
            'delosfei.generator.path.assets',
            resource_path('assets/')
        );

        $this->pathSeeder = config('delosfei.generator.path.seeder', database_path('seeders/'));
        $this->pathDatabaseSeeder = config('delosfei.generator.path.database_seeder', database_path('seeders/DatabaseSeeder.php'));
        $this->pathViewProvider = config(
            'delosfei.generator.path.view_provider',
            app_path('Providers/ViewServiceProvider.php')
        );

    }

    public function loadDynamicVariables(CommandData &$commandData)
    {
        $commandData->addDynamicVariable('$NAMESPACE_APP$', $this->nsApp);
        $commandData->addDynamicVariable('$NAMESPACE_REPOSITORY$', $this->nsRepository);
        $commandData->addDynamicVariable('$NAMESPACE_MODEL$', $this->nsModel);
        $commandData->addDynamicVariable('$NAMESPACE_DATATABLES$', $this->nsDataTables);
        $commandData->addDynamicVariable('$NAMESPACE_MODEL_EXTEND$', $this->nsModelExtend);

        $commandData->addDynamicVariable('$NAMESPACE_SEEDER$', $this->nsSeeder);
        $commandData->addDynamicVariable('$NAMESPACE_FACTORY$', $this->nsFactory);

        $commandData->addDynamicVariable('$NAMESPACE_API_CONTROLLER$', $this->nsApiController);
        $commandData->addDynamicVariable('$NAMESPACE_API_RESOURCE$', $this->nsApiResource);
        $commandData->addDynamicVariable('$NAMESPACE_API_REQUEST$', $this->nsApiRequest);

        $commandData->addDynamicVariable('$NAMESPACE_BASE_CONTROLLER$', $this->nsBaseController);
        $commandData->addDynamicVariable('$NAMESPACE_CONTROLLER$', $this->nsController);
        $commandData->addDynamicVariable('$NAMESPACE_REQUEST$', $this->nsRequest);
        $commandData->addDynamicVariable('$NAMESPACE_REQUEST_BASE$', $this->nsRequestBase);

        $commandData->addDynamicVariable('$TABLE_NAME$', $this->tableName);
        $commandData->addDynamicVariable('$TABLE_NAME_TITLE$', Str::studly($this->tableName));
        $commandData->addDynamicVariable('$PRIMARY_KEY_NAME$', $this->primaryName);

        $commandData->addDynamicVariable('$MODEL_NAME$', $this->mName);
        $commandData->addDynamicVariable('$MODEL_NAME_CAMEL$', $this->mCamel);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL$', $this->mPlural);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL_CAMEL$', $this->mCamelPlural);
        $commandData->addDynamicVariable('$MODEL_NAME_SNAKE$', $this->mSnake);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL_SNAKE$', $this->mSnakePlural);
        $commandData->addDynamicVariable('$MODEL_NAME_DASHED$', $this->mDashed);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL_DASHED$', $this->mDashedPlural);
        $commandData->addDynamicVariable('$MODEL_NAME_SLASH$', $this->mSlash);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL_SLASH$', $this->mSlashPlural);
        $commandData->addDynamicVariable('$MODEL_NAME_HUMAN$', $this->mHuman);
        $commandData->addDynamicVariable('$MODEL_NAME_PLURAL_HUMAN$', $this->mHumanPlural);
        $commandData->addDynamicVariable('$FILES$', '');

        $connectionText = '';
        if ($connection = $this->getOption('connection')) {
            $this->connection = $connection;
            $connectionText = infy_tab(4).'public $connection = "'.$connection.'";';
        }
        $commandData->addDynamicVariable('$CONNECTION$', $connectionText);

        if (!empty($this->prefixes['route'])) {
            $commandData->addDynamicVariable('$ROUTE_NAMED_PREFIX$', $this->prefixes['route'].'.');
            $commandData->addDynamicVariable('$ROUTE_PREFIX$', str_replace('.', '/', $this->prefixes['route']).'/');
            $commandData->addDynamicVariable('$RAW_ROUTE_PREFIX$', $this->prefixes['route']);
        } else {
            $commandData->addDynamicVariable('$ROUTE_PREFIX$', '');
            $commandData->addDynamicVariable('$ROUTE_NAMED_PREFIX$', '');
        }

        if (!empty($this->prefixes['ns'])) {
            $commandData->addDynamicVariable('$path_PREFIX$', $this->prefixes['ns'].'\\');
        } else {
            $commandData->addDynamicVariable('$path_PREFIX$', '');
        }

        if (!empty($this->prefixes['view'])) {
            $commandData->addDynamicVariable('$VIEW_PREFIX$', str_replace('/', '.', $this->prefixes['view']).'.');
        } else {
            $commandData->addDynamicVariable('$VIEW_PREFIX$', '');
        }

        if (!empty($this->prefixes['public'])) {
            $commandData->addDynamicVariable('$PUBLIC_PREFIX$', $this->prefixes['public']);
        } else {
            $commandData->addDynamicVariable('$PUBLIC_PREFIX$', '');
        }

        $commandData->addDynamicVariable(
            '$API_PREFIX$',
            config('delosfei.generator.api_prefix', 'api')
        );

        $commandData->addDynamicVariable(
            '$API_VERSION$',
            config('delosfei.generator.api_version', 'v1')
        );

        $commandData->addDynamicVariable('$SEARCHABLE$', '');

        return $commandData;
    }

    public function prepareTableName()
    {
        if ($this->getOption('tableName')) {
            $this->tableName = $this->getOption('tableName');
        } else {
            $this->tableName = $this->mSnakePlural;
        }
    }

    public function preparePrimaryName()
    {
        if ($this->getOption('primary')) {
            $this->primaryName = $this->getOption('primary');
        } else {
            $this->primaryName = 'id';
        }
    }

    public function prepareModelNames()
    {
        if ($this->getOption('plural')) {
            $this->mPlural = $this->getOption('plural');
        } else {
            $this->mPlural = Str::plural($this->mName);
        }
        $this->mCamel = Str::camel($this->mName);
        $this->mCamelPlural = Str::camel($this->mPlural);
        $this->mSnake = Str::snake($this->mName);
        $this->mSnakePlural = Str::snake($this->mPlural);
        $this->mDashed = str_replace('_', '-', Str::snake($this->mSnake));
        $this->mDashedPlural = str_replace('_', '-', Str::snake($this->mSnakePlural));
        $this->mSlash = str_replace('_', '/', Str::snake($this->mSnake));
        $this->mSlashPlural = str_replace('_', '/', Str::snake($this->mSnakePlural));
        $this->mHuman = Str::title(str_replace('_', ' ', Str::snake($this->mSnake)));
        $this->mHumanPlural = Str::title(str_replace('_', ' ', Str::snake($this->mSnakePlural)));
    }

    public function prepareOptions(CommandData &$commandData)
    {
        foreach (self::$availableOptions as $option) {
            $this->options[$option] = $commandData->commandObj->option($option);
        }

        if (isset($options['fromTable']) and $this->options['fromTable']) {
            if (!$this->options['tableName']) {
                $commandData->commandError('tableName required with fromTable option.');
                exit;
            }
        }

        if (empty($this->options['save'])) {
            $this->options['save'] = config('delosfei.generator.options.save_schema_file', true);
        }

        $this->options['softDelete'] = config('delosfei.generator.options.softDelete', false);
        $this->options['repositoryPattern'] = config('delosfei.generator.options.repository_pattern', true);
        $this->options['resources'] = config('delosfei.generator.options.resources', true);
        if (!empty($this->options['skip'])) {
            $this->options['skip'] = array_map('trim', explode(',', $this->options['skip']));
        }

        if (!empty($this->options['datatables'])) {
            if (strtolower($this->options['datatables']) == 'true') {
                $this->addOns['datatables'] = true;
            } else {
                $this->addOns['datatables'] = false;
            }
        }
    }

    public function preparePrefixes()
    {
        $this->prefixes['route'] = explode('/', config('delosfei.generator.prefixes.route', ''));
        $this->prefixes['path'] = explode('/', config('delosfei.generator.prefixes.path', ''));
        $this->prefixes['view'] = explode('.', config('delosfei.generator.prefixes.view', ''));
        $this->prefixes['public'] = explode('/', config('delosfei.generator.prefixes.public', ''));

        if ($this->getOption('prefix')) {
            $multiplePrefixes = explode('/', $this->getOption('prefix'));

            $this->prefixes['route'] = array_merge($this->prefixes['route'], $multiplePrefixes);
            $this->prefixes['path'] = array_merge($this->prefixes['path'], $multiplePrefixes);
            $this->prefixes['view'] = array_merge($this->prefixes['view'], $multiplePrefixes);
            $this->prefixes['public'] = array_merge($this->prefixes['public'], $multiplePrefixes);
        }

        $this->prefixes['route'] = array_diff($this->prefixes['route'], ['']);
        $this->prefixes['path'] = array_diff($this->prefixes['path'], ['']);
        $this->prefixes['view'] = array_diff($this->prefixes['view'], ['']);
        $this->prefixes['public'] = array_diff($this->prefixes['public'], ['']);

        $routePrefix = '';

        foreach ($this->prefixes['route'] as $singlePrefix) {
            $routePrefix .= Str::camel($singlePrefix).'.';
        }

        if (!empty($routePrefix)) {
            $routePrefix = substr($routePrefix, 0, strlen($routePrefix) - 1);
        }

        $this->prefixes['route'] = $routePrefix;

        $nsPrefix = '';

        foreach ($this->prefixes['path'] as $singlePrefix) {
            $nsPrefix .= Str::title($singlePrefix).'\\';
        }

        if (!empty($nsPrefix)) {
            $nsPrefix = substr($nsPrefix, 0, strlen($nsPrefix) - 1);
        }

        $this->prefixes['ns'] = $nsPrefix;

        $pathPrefix = '';

        foreach ($this->prefixes['path'] as $singlePrefix) {
            $pathPrefix .= Str::title($singlePrefix).'/';
        }

        if (!empty($pathPrefix)) {
            $pathPrefix = substr($pathPrefix, 0, strlen($pathPrefix) - 1);
        }

        $this->prefixes['path'] = $pathPrefix;

        $viewPrefix = '';

        foreach ($this->prefixes['view'] as $singlePrefix) {
            $viewPrefix .= Str::camel($singlePrefix).'/';
        }

        if (!empty($viewPrefix)) {
            $viewPrefix = substr($viewPrefix, 0, strlen($viewPrefix) - 1);
        }

        $this->prefixes['view'] = $viewPrefix;

        $publicPrefix = '';

        foreach ($this->prefixes['public'] as $singlePrefix) {
            $publicPrefix .= Str::camel($singlePrefix).'/';
        }

        if (!empty($publicPrefix)) {
            $publicPrefix = substr($publicPrefix, 0, strlen($publicPrefix) - 1);
        }

        $this->prefixes['public'] = $publicPrefix;
    }

    public function overrideOptionsFromJsonFile($jsonData)
    {
        $options = self::$availableOptions;

        foreach ($options as $option) {
            if (isset($jsonData['options'][$option])) {
                $this->setOption($option, $jsonData['options'][$option]);
            }
        }

        // prepare prefixes than reload namespaces, paths and dynamic variables
        if (!empty($this->getOption('prefix'))) {
            $this->preparePrefixes();
            $this->loadPaths();
            $this->loadNamespaces($this->commandData);
            $this->loadDynamicVariables($this->commandData);
        }

        $addOns = ['swagger', 'tests', 'datatables'];

        foreach ($addOns as $addOn) {
            if (isset($jsonData['addOns'][$addOn])) {
                $this->addOns[$addOn] = $jsonData['addOns'][$addOn];
            }
        }
    }

    public function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }

        return false;
    }

    public function getAddOn($addOn)
    {
        if (isset($this->addOns[$addOn])) {
            return $this->addOns[$addOn];
        }

        return false;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    public function prepareAddOns()
    {
        $this->addOns['swagger'] = config('delosfei.generator.add_on.swagger', false);
        $this->addOns['tests'] = config('delosfei.generator.add_on.tests', false);
        $this->addOns['datatables'] = config('delosfei.generator.add_on.datatables', false);
        $this->addOns['menu.enabled'] = config('delosfei.generator.add_on.menu.enabled', false);
        $this->addOns['menu.menu_file'] = config('delosfei.generator.add_on.menu.menu_file', 'layouts.menu');
    }
}

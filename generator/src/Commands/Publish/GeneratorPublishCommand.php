<?php

namespace Delosfei\Generator\Commands\Publish;

use Delosfei\Generator\Utils\FileUtil;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;

class GeneratorPublishCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ds:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes & init api routes, base controller, base test cases traits.';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->copyFiles();
        $this->publishTestCases();
        $this->publishBaseController();
        $repositoryPattern = config('delosfei.generator.options.repository_pattern', true);
        if ($repositoryPattern) {
            $this->publishBaseRepository();
        }
        if ($this->option('localized')) {
            $this->publishLocaleFiles();
        }
    }
    private function copyFiles()
    {
        $destinationDir = config('delosfei.generator.path.system', base_path());

        $templateType = config('delosfei.generator.templates', 'dsvue2-templates');

        $sourceDir = get_templates_package_path($templateType).'/templates/vue2';
        if (File::copyDirectory($sourceDir, $destinationDir)) {

            $this->info('Published system base files');
        }


    }





    /**
     * Replaces dynamic variables of template.
     *
     * @param string $templateData
     *
     * @return string
     */
    private function fillTemplate($templateData)
    {
        $apiVersion = config('delosfei.generator.api_version', 'v1');
        $apiPrefix = config('delosfei.generator.api_prefix', 'api');

        $templateData = str_replace('$API_VERSION$', $apiVersion, $templateData);
        $templateData = str_replace('$API_PREFIX$', $apiPrefix, $templateData);
        $appNamespace = $this->getLaravel()->getNamespace();
        $appNamespace = substr($appNamespace, 0, strlen($appNamespace) - 1);
        $templateData = str_replace('$NAMESPACE_APP$', $appNamespace, $templateData);

        return $templateData;
    }

    private function publishTestCases()
    {
        $testsPath = config('delosfei.generator.path.tests', base_path('tests/'));
        $testsNameSpace = config('delosfei.generator.namespace.tests', 'Tests');
        $createdAtField = config('delosfei.generator.timestamps.created_at', 'created_at');
        $updatedAtField = config('delosfei.generator.timestamps.updated_at', 'updated_at');

        $templateData = get_template('test.api_test_trait', 'generator');

        $templateData = str_replace('$NAMESPACE_TESTS$', $testsNameSpace, $templateData);
        $templateData = str_replace('$TIMESTAMPS$', "['$createdAtField', '$updatedAtField']", $templateData);

        $fileName = 'ApiTestTrait.php';

        if (file_exists($testsPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($testsPath, $fileName, $templateData);
        $this->info('ApiTestTrait created');

        $testAPIsPath = config('delosfei.generator.path.api_test', base_path('tests/APIs/'));
        if (!file_exists($testAPIsPath)) {
            FileUtil::createDirectoryIfNotExist($testAPIsPath);
            $this->info('APIs Tests directory created');
        }

        $testRepositoriesPath = config('delosfei.generator.path.repository_test', base_path('tests/Repositories/'));
        if (!file_exists($testRepositoriesPath)) {
            FileUtil::createDirectoryIfNotExist($testRepositoriesPath);
            $this->info('Repositories Tests directory created');
        }
    }

    private function publishBaseController()
    {
        $templateData = get_template('app_base_controller', 'generator');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = app_path('Http/Controllers/');

        $fileName = 'AppBaseController.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('AppBaseController created');
    }

    private function publishBaseRepository()
    {
        $templateData = get_template('base_repository', 'generator');

        $templateData = $this->fillTemplate($templateData);

        $repositoryPath = app_path('Repositories/');

        FileUtil::createDirectoryIfNotExist($repositoryPath);

        $fileName = 'BaseRepository.php';

        if (file_exists($repositoryPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($repositoryPath, $fileName, $templateData);

        $this->info('BaseRepository created');
    }

    private function publishLocaleFiles()
    {
        $localesDir = __DIR__.'/../../../locale/';

        $this->publishDirectory($localesDir, resource_path('lang'), 'lang', true);

        $this->comment('Locale files published');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['localized', null, InputOption::VALUE_NONE, 'Localize files.'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }
}

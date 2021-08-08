<?php

namespace Delosfei\Generator\Commands\Publish;

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
    protected $description = 'Publishes & init api routes, base controller, base test cases traits, base repository, base request, base policy.';
    /**
     * @var string
     */
    private $fileName;
    private $path;

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
//        $this->copyFiles();
        $this->publishBaseController();
        $this->publishBaseRequest();
        $this->publishBasePolicy();
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

    private function publishBaseController()
    {
        $templateData = get_template('app_base_controller', 'generator');
        $templateData = $this->fillTemplate($templateData);
        $this->path = app_path('Http/Controllers/');
        $this->fileName = 'Controller.php';
        if ($this->option('rollback')) {
            $this->deleteFileAndShowInfoIfExists($this->path, $this->fileName);
        } else {
            $this->createFileAndShowInfo($this->path, $this->fileName, $templateData);
        }
    }

    private function publishBaseRequest()
    {
        $templateData = get_template('app_base_request', 'generator');
        $templateData = $this->fillTemplate($templateData);
        $this->path = app_path('Http/Requests/');
        $this->fileName = 'Request.php';
        if ($this->option('rollback')) {
            $this->deleteFileAndShowInfoIfExists($this->path, $this->fileName);
        } else {
            $this->createFileAndShowInfo($this->path, $this->fileName, $templateData);
        }
    }

    private function publishBasePolicy()
    {
        $templateData = get_template('app_base_policy', 'generator');
        $templateData = $this->fillTemplate($templateData);
        $this->path = app_path('Policies/');
        $this->fileName = 'Policy.php';
        if ($this->option('rollback')) {
            $this->deleteFileAndShowInfoIfExists($this->path, $this->fileName);
        } else {
            $this->createFileAndShowInfo($this->path, $this->fileName, $templateData);
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return [
            ['rollback', null, InputOption::VALUE_NONE, 'rollback published files.'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [];
    }
}

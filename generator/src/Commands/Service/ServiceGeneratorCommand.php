<?php

namespace Delosfei\Generator\Commands\Service;

use Delosfei\Generator\Commands\Publish\PublishBaseCommand;
use Delosfei\Generator\Utils\FileUtil;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class ServiceGeneratorCommand extends PublishBaseCommand
{


    protected $serviceName;
    protected $servicesPath;
    protected $dynamicVars;
    protected $existingConfigAppContents;
    protected $configapp_providers_templateData;
    protected $configapp_aliases_templateData;
    protected $configApppath;

    protected $name = 'ds:service';
    protected $description = 'Create a full static service for given name';


    public function handle()
    {
        $this->serviceName = ucfirst($this->arguments()['name']);
        $this->servicesPath = config('delosfei.generator.path.services', app_path('Services/')).$this->serviceName.'/';
        $this->configApppath = base_path('config/app.php');
        $this->existingConfigAppContents = file_get_contents($this->configApppath);
        $this->dynamicVars = [
            '$NAMESPACE_SERVICE$' => config('delosfei.generator.namespace.service', 'App\Services'),
            '$SERVICE_NAME$' => $this->serviceName,
        ];
        $this->configapp_providers_templateData = get_template('service.configapp_providers', 'generator');
        $this->configapp_providers_templateData = fill_template($this->dynamicVars, $this->configapp_providers_templateData);
        $this->configapp_aliases_templateData = get_template('service.configapp_aliases', 'generator');
        $this->configapp_aliases_templateData = fill_template($this->dynamicVars, $this->configapp_aliases_templateData);
        if (!$this->option('rollback')) {
            FileUtil::createDirectoryIfNotExist($this->servicesPath);
            $this->copyServicefiles();
            $this->addProvidersToConfigApp();
            $this->addAliasesToConfigApp();
        } else {
            $this->delServicefiles();
            if (file_exists($this->servicesPath)) {
                rmdir($this->servicesPath);
            }
            $this->delProvidersAndAliasesfromConfigApp();
        }
    }

    private function copyServicefiles()
    {
        $files = $this->getServicefiles();

        foreach ($files as $stub => $blade) {
            $sourceFile = get_template_file_path($stub, 'generator');
            $templateData = file_get_contents($sourceFile);
            $templateData = fill_template($this->dynamicVars, $templateData);
            if (file_exists($this->servicesPath.$blade) && !$this->confirmOverwrite($blade)) {
                return;
            }
            FileUtil::createFile($this->servicesPath, $blade, $templateData);

            $this->info('+ '.$this->servicesPath.$blade);
        }
    }

    private function delServicefiles()
    {
        $files = $this->getServicefiles();
        if (file_exists($this->servicesPath)) {
            foreach ($files as $blade) {
                FileUtil::deleteFile($this->servicesPath, $blade);
                $this->info('- '.$this->servicesPath.$blade);
            }
        }
    }

    private function getServicefiles(): array
    {
        return [
            'service/facade' => $this->serviceName.'Facade.php',
            'service/service' => $this->serviceName.'Service.php',
            'service/provider' => $this->serviceName.'ServiceProvider.php',
        ];
    }

    public function addProvidersToConfigApp()
    {
        if (Str::contains($this->existingConfigAppContents, $this->configapp_providers_templateData)) {
            $this->info('+ '.$this->configApppath.' (Skipping Providers)');

            return;
        }
        $this->existingConfigAppContents = str_replace(
            "'providers' => [",
            "'providers' => [".infy_nl_tab(1, 2).$this->configapp_providers_templateData,
            $this->existingConfigAppContents
        );
        file_put_contents($this->configApppath, $this->existingConfigAppContents);
        $this->info('+ '.$this->configApppath.' (update Providers)');
    }

    public function addAliasesToConfigApp()
    {
        if (Str::contains($this->existingConfigAppContents, $this->configapp_aliases_templateData)) {
            $this->info('+ '.$this->configApppath.' (Skipping Aliases)');

            return;
        }
        $this->existingConfigAppContents = str_replace(
            "'aliases' => [",
            "'aliases' => [".infy_nl_tab(1, 2).$this->configapp_aliases_templateData,
            $this->existingConfigAppContents
        );
        file_put_contents($this->configApppath, $this->existingConfigAppContents);
        $this->info('+ '.$this->configApppath.' (update Aliases)');
    }

    public function delProvidersAndAliasesfromConfigApp()
    {
        if (Str::contains($this->existingConfigAppContents, $this->configapp_providers_templateData)) {
            $this->existingConfigAppContents = str_replace(
                "'providers' => [".infy_nl_tab(1, 2).$this->configapp_providers_templateData,
                "'providers' => [",
                $this->existingConfigAppContents
            );
            file_put_contents($this->configApppath, $this->existingConfigAppContents);
            $this->info('- '.$this->configApppath.' (update Providers)');
        }
        if (Str::contains($this->existingConfigAppContents, $this->configapp_aliases_templateData)) {
            $this->existingConfigAppContents = str_replace(
                "'aliases' => [".infy_nl_tab(1, 2).$this->configapp_aliases_templateData,
                "'aliases' => [",
                $this->existingConfigAppContents
            );
            file_put_contents($this->configApppath, $this->existingConfigAppContents);
            $this->info('- '.$this->configApppath.' (update Aliases)');
        }

    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['rollback', null, InputOption::VALUE_NONE, 'rollback service.'],
        ];
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Singular name of service'],
        ];
    }
}

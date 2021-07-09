<?php

namespace Delosfei\Generator\Commands\Publish;

use Delosfei\Generator\Utils\FileUtil;
use Symfony\Component\Console\Input\InputOption;

class PublishLayoutCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ds.publish:layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes auth files';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->copyView();
        $this->publishHomeController();
    }

    private function copyView()
    {
        $viewsPath = config('delosfei.generator.path.views', resource_path('views/'));
        $templateType = config('delosfei.generator.templates', 'adminlte-templates');

        $this->createDirectories($viewsPath);

        $files = $this->getViews();

        foreach ($files as $stub => $blade) {
            $sourceFile = get_template_file_path('scaffold/'.$stub, $templateType);
            $destinationFile = $viewsPath.$blade;
            $this->publishFile($sourceFile, $destinationFile, $blade);
        }
    }

    private function createDirectories($viewsPath)
    {
        FileUtil::createDirectoryIfNotExist($viewsPath.'layouts');

    }

    private function getViews()
    {
        $views = [
            'layouts/app' => 'layouts/app.blade.php',
            'layouts/sidebar' => 'layouts/sidebar.blade.php',

        ];


        return $views;
    }

    private function publishHomeController()
    {
        $templateData = get_template('home_controller', 'generator');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = config('delosfei.generator.path.controller', app_path('Http/Controllers/'));

        $fileName = 'HomeController.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('HomeController created');
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
        $templateData = str_replace(
            '$NAMESPACE_CONTROLLER$',
            config('delosfei.generator.namespace.controller'),
            $templateData
        );

        $templateData = str_replace(
            '$NAMESPACE_REQUEST$',
            config('delosfei.generator.namespace.request'),
            $templateData
        );

        return $templateData;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
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

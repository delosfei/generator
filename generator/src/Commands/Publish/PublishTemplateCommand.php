<?php

namespace Delosfei\Generator\Commands\Publish;

class PublishTemplateCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'delos.publish:templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes api generator templates.';

    private $templatesDir;

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->templatesDir = config(
            'delos.laravel_generator.path.templates_dir',
            resource_path('delos/delos-generator-templates/')
        );

        if ($this->publishGeneratorTemplates()) {
            $this->publishScaffoldTemplates();
            $this->publishSwaggerTemplates();
        }
    }

    /**
     * Publishes templates.
     */
    public function publishGeneratorTemplates()
    {
        $templatesPath = __DIR__.'/../../../templates';

        return $this->publishDirectory($templatesPath, $this->templatesDir, 'delos-generator-templates');
    }

    /**
     * Publishes scaffold stemplates.
     */
    public function publishScaffoldTemplates()
    {
        $templateType = config('delos.laravel_generator.templates', 'adminlte-templates');

        $templatesPath = get_templates_package_path($templateType).'/templates/scaffold';

        return $this->publishDirectory($templatesPath, $this->templatesDir.'scaffold', 'delos-generator-templates/scaffold', true);
    }

    /**
     * Publishes swagger stemplates.
     */
    public function publishSwaggerTemplates()
    {
        $templatesPath = base_path('vendor/delosfei/swagger-generator/templates');

        return $this->publishDirectory($templatesPath, $this->templatesDir, 'swagger-generator', true);
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

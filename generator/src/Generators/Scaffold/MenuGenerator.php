<?php

namespace Delosfei\Generator\Generators\Scaffold;

use Illuminate\Support\Str;
use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;

class MenuGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $templateType;

    /** @var string */
    private $menuContents;

    /** @var string */
    private $menuTemplate;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = config(
                'delosfei.generator.path.views',
                resource_path(
                    'views/'
                )
            ).$commandData->getAddOn('menu.menu_file');
        $this->templateType = config('delosfei.generator.templates', 'adminlte-templates');

        $this->menuContents = file_get_contents($this->path);

        $templateName = 'menu_template';

        if ($this->commandData->isLocalizedTemplates()) {
            $templateName .= '_locale';
        }

        $this->menuTemplate = get_template('scaffold.layouts.'.$templateName, $this->templateType);

        $this->menuTemplate = fill_template($this->commandData->dynamicVars, $this->menuTemplate);
    }

    public function generate()
    {
        $this->menuContents .= $this->menuTemplate.infy_nl();
        $existingMenuContents = file_get_contents($this->path);
        // adminlte uses <p> tab and coreui+stisla uses <span> tag for menu
        if (Str::contains($existingMenuContents, '<p>'.$this->commandData->config->mHumanPlural.'</p>') or
            Str::contains($existingMenuContents, '<span>'.$this->commandData->config->mHumanPlural.'</span>')) {
            $this->commandData->commandInfo('+ '.$this->path.$this->commandData->config->mHumanPlural.' (Skipping)');

            return;
        }

        file_put_contents($this->path, $this->menuContents);
        $this->commandData->commandInfo('+ '.$this->path.$this->commandData->config->mHumanPlural.' (update)');

    }

    public function rollback()
    {
        if (Str::contains($this->menuContents, $this->menuTemplate)) {
            file_put_contents($this->path, str_replace($this->menuTemplate, '', $this->menuContents));
            $this->commandData->commandInfo('- '.$this->path.$this->commandData->config->mHumanPlural.' (update)');
        }
    }
}

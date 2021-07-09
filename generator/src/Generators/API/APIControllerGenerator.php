<?php

namespace Delosfei\Generator\Generators\API;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;

class APIControllerGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $fileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathApiController;
        $this->fileName = $this->commandData->modelName.'Controller.php';
    }

    public function generate()
    {
        if ($this->commandData->getOption('repositoryPattern')) {
            $templateName = 'api_controller';
        } else {
            $templateName = 'model_api_controller';
        }


        if ($this->commandData->getOption('resources')) {
            $templateName .= '_resource';
        }

        $templateData = get_template("api.controller.$templateName", 'generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        if (file_exists($this->path.$this->fileName) && !$this->commandData->commandObj->confirmOverwrite($this->fileName)) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->path, $this->fileName, $templateData));
    }

    public function rollback()
    {
        ($del_path = $this->rollbackFile($this->path, $this->fileName)) ? $this->commandData->commandComment($del_path) : false;
    }
}

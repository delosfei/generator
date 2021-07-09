<?php

namespace Delosfei\Generator\Generators\Scaffold;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;
use Delosfei\Generator\Generators\ModelGenerator;
use Delosfei\Generator\Utils\FileUtil;

class RequestGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $createFileName;

    /** @var string */
    private $updateFileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathRequest;
        $this->createFileName = 'Create'.$this->commandData->modelName.'Request.php';
        $this->updateFileName = 'Update'.$this->commandData->modelName.'Request.php';
    }

    public function generate()
    {
        $this->generateCreateRequest();
        $this->generateUpdateRequest();
    }

    private function generateCreateRequest()
    {
        $templateData = get_template('scaffold.request.create_request', 'generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        if (file_exists($this->path.$this->createFileName) && !$this->commandData->commandObj->confirmOverwrite($this->createFileName)) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->path, $this->createFileName, $templateData));
    }

    private function generateUpdateRequest()
    {
        $modelGenerator = new ModelGenerator($this->commandData);
        $rules = $modelGenerator->generateUniqueRules();
        $this->commandData->addDynamicVariable('$UNIQUE_RULES$', $rules);

        $templateData = get_template('scaffold.request.update_request', 'generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        if (file_exists($this->path.$this->updateFileName) && !$this->commandData->commandObj->confirmOverwrite($this->updateFileName)) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->path, $this->updateFileName, $templateData));

    }

    public function rollback()
    {
        ($del_path = $this->rollbackFile($this->path, $this->createFileName)) ? $this->commandData->commandComment($del_path) : false;
        ($del_path = $this->rollbackFile($this->path, $this->updateFileName)) ? $this->commandData->commandComment($del_path) : false;


    }
}

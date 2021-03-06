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

        FileUtil::createFile($this->path, $this->createFileName, $templateData);

        $this->commandData->commandInfo('+ '.$this->path.$this->createFileName);
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
        FileUtil::createFile($this->path, $this->updateFileName, $templateData);

        $this->commandData->commandInfo('+ '.$this->path.$this->updateFileName);

    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->createFileName)) {
            $this->commandData->commandInfo('- '.$this->path.$this->createFileName);
        }

        if ($this->rollbackFile($this->path, $this->updateFileName)) {
            $this->commandData->commandInfo('- '.$this->path.$this->updateFileName);
        }
    }
}

<?php

namespace Delosfei\Generator\Generators\Scaffold;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;

class RequestGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $FileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathRequest;
        $this->FileName = $this->commandData->modelName.'Request.php';
    }

    public function generate()
    {
        $this->generateRequest();
    }

    private function generateRequest()
    {
        $templateData = get_template('scaffold.request.create_request', 'generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        if (file_exists($this->path.$this->FileName) && !$this->commandData->commandObj->confirmOverwrite($this->FileName)) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->path, $this->FileName, $templateData));
    }


    public function rollback()
    {
        ($del_path = $this->rollbackFile($this->path, $this->FileName)) ? $this->commandData->commandComment($del_path) : false;


    }
}

<?php

namespace Delosfei\Generator\Generators\API;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;

class APIPolicyGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $FileName;

    /** @var string */


    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathPolicy;
        $this->FileName = $this->commandData->modelName.'Policy.php';
    }

    public function generate()
    {
        $this->generatePolicy();
    }

    private function generatePolicy()
    {
        $templateData = get_template('policy.policy', 'generator');

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

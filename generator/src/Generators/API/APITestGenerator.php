<?php

namespace Delosfei\Generator\Generators\API;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;
use Delosfei\Generator\Utils\FileUtil;

class APITestGenerator extends BaseGenerator
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
        $this->path = $commandData->config->pathApiTests;
        $this->fileName = $this->commandData->modelName.'ApiTest.php';
    }

    public function generate()
    {
        $templateData = get_template('api.test.api_test', 'generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        if (file_exists($this->path.$this->fileName) && !$this->commandData->commandObj->confirmOverwrite($this->fileName)) {
            return;
        }

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandInfo('+ '.$this->path.$this->fileName);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandInfo('- '.$this->path.$this->fileName);
        }
    }
}

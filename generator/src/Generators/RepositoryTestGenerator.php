<?php

namespace Delosfei\Generator\Generators;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Utils\FileUtil;

class RepositoryTestGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $fileName;

    public function __construct($commandData)
    {
        $this->commandData = $commandData;
        $this->path = config('delosfei.generator.path.repository_test', base_path('tests/Repositories/'));
        $this->fileName = $this->commandData->modelName.'RepositoryTest.php';
    }

    public function generate()
    {
        $templateData = get_template('test.repository_test', 'generator');

        $templateData = $this->fillTemplate($templateData);

        if (file_exists($this->path.$this->fileName) && !$this->commandData->commandObj->confirmOverwrite($this->fileName)) {
            return;
        }


        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandInfo('+ '.$this->path.$this->fileName);

    }

    private function fillTemplate($templateData)
    {
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        return $templateData;
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandInfo('- '.$this->path.$this->fileName);
        }
    }
}

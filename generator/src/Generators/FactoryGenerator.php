<?php

namespace Delosfei\Generator\Generators;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Utils\FileUtil;
use Delosfei\Generator\Utils\GeneratorFieldsInputUtil;

/**
 * Class FactoryGenerator.
 */
class FactoryGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;
    /** @var string */
    private $path;
    /** @var string */
    private $fileName;

    /**
     * FactoryGenerator constructor.
     *
     * @param CommandData $commandData
     */
    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathFactory;
        $this->fileName = $this->commandData->modelName.'Factory.php';
    }

    public function generate()
    {
        $templateData = get_template('factories.model_factory', 'generator');

        $templateData = $this->fillTemplate($templateData);
        if (file_exists($this->path.$this->fileName) && !$this->commandData->commandObj->confirmOverwrite($this->fileName)) {
            return;
        }


        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandInfo('+ '.$this->path.$this->fileName);
    }

    /**
     * @param string $templateData
     *
     * @return mixed|string
     */
    private function fillTemplate($templateData)
    {
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace(
            '$FIELDS$',
            implode(','.infy_nl_tab(1, 2), $this->generateFields()),
            $templateData
        );

        return $templateData;
    }

    /**
     * @return array
     */
    private function generateFields()
    {
        $fields = [];

        foreach ($this->commandData->fields as $field) {
            if ($field->isPrimary) {
                continue;
            }

            $fieldData = "'".$field->name."' => ".'$this->faker->';

            switch ($field->fieldType) {
                case 'integer':
                case 'float':
                case 'unsignedInteger':
                case 'bigInteger':
                    $fakerData = 'randomDigitNotNull';
                    break;
                case 'string':
                    $fakerData = 'word';
                    break;
                case 'text':
                    $fakerData = 'text';
                    break;
                case 'datetime':
                case 'timestamp':
                    $fakerData = "date('Y-m-d H:i:s')";
                    break;
                case 'enum':
                    $fakerData = 'randomElement('.
                        GeneratorFieldsInputUtil::prepareValuesArrayStr($field->htmlValues).
                        ')';
                    break;
                case 'boolean':
                    $fakerData = 'randomElement(['."'0','1'".'])';
                    break;
                default:
                    $fakerData = 'word';
            }

            $fieldData .= $fakerData;

            $fields[] = $fieldData;
        }

        return $fields;
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandInfo('- '.$this->path.$this->fileName);
        }
    }
}

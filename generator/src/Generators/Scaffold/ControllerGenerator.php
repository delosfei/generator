<?php

namespace Delosfei\Generator\Generators\Scaffold;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;
use Delosfei\Generator\Utils\FileUtil;

class ControllerGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $templateType;

    /** @var string */
    private $fileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathController;
        $this->templateType = config('delosfei.generator.templates', 'adminlte-templates');
        $this->fileName = $this->commandData->modelName.'Controller.php';
    }

    public function generate()
    {
        if ($this->commandData->getAddOn('datatables')) {
            if ($this->commandData->getOption('repositoryPattern')) {
                $templateName = 'datatable_controller';
            } else {
                $templateName = 'model_datatable_controller';
            }

            if ($this->commandData->isLocalizedTemplates()) {
                $templateName .= '_locale';
            }

            $templateData = get_template("scaffold.controller.$templateName", 'generator');

            $this->generateDataTable();
        } elseif ($this->commandData->jqueryDT()) {
            $templateName = 'jquery_datatable_controller';
            $templateData = get_template("scaffold.controller.$templateName", 'generator');

            $this->generateDataTable();
        } else {
            if ($this->commandData->getOption('repositoryPattern')) {
                $templateName = 'controller';
            } else {
                $templateName = 'model_controller';
            }
            if ($this->commandData->isLocalizedTemplates()) {
                $templateName .= '_locale';
            }

            $templateData = get_template("scaffold.controller.$templateName", 'generator');

            $paginate = $this->commandData->getOption('paginate');

            if ($paginate) {
                $templateData = str_replace('$RENDER_TYPE$', 'paginate('.$paginate.')', $templateData);
            } else {
                $templateData = str_replace('$RENDER_TYPE$', 'all()', $templateData);
            }
        }

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        if (file_exists($this->path.$this->fileName) && !$this->commandData->commandObj->confirmOverwrite($this->fileName)) {
            return;
        }

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandComment('+ '.$this->path.$this->fileName);
    }

    private function generateDataTable()
    {
        $templateName = ($this->commandData->jqueryDT()) ? 'jquery_datatable' : 'datatable';
        if ($this->commandData->isLocalizedTemplates()) {
            $templateName .= '_locale';
        }

        $templateData = get_template('scaffold.'.$templateName, 'generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace(
            '$DATATABLE_COLUMNS$',
            implode(','.infy_nl_tab(1, 3), $this->generateDataTableColumns()),
            $templateData
        );

        $path = $this->commandData->config->pathDataTables;

        $fileName = $this->commandData->modelName.'DataTable.php';

        if (file_exists($this->path.$this->fileName) && !$this->commandData->commandObj->confirmOverwrite($this->fileName)) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->path, $this->fileName, $templateData));
    }

    private function generateDataTableColumns()
    {
        $templateName = 'datatable_column';
        if ($this->commandData->isLocalizedTemplates()) {
            $templateName .= '_locale';
        }
        $headerFieldTemplate = get_template('scaffold.views.'.$templateName, $this->templateType);

        $dataTableColumns = [];
        foreach ($this->commandData->fields as $field) {
            if (!$field->inIndex) {
                continue;
            }

            if ($this->commandData->isLocalizedTemplates() && !$field->isSearchable) {
                $headerFieldTemplate = str_replace('$SEARCHABLE$', ",'searchable' => false", $headerFieldTemplate);
            }

            $fieldTemplate = fill_template_with_field_data(
                $this->commandData->dynamicVars,
                $this->commandData->fieldNamesMapping,
                $headerFieldTemplate,
                $field
            );

            if ($field->isSearchable) {
                $dataTableColumns[] = $fieldTemplate;
            } else {
                if ($this->commandData->isLocalizedTemplates()) {
                    $dataTableColumns[] = $fieldTemplate;
                } else {
                    $dataTableColumns[] = "'".$field->name."' => ['searchable' => false]";
                }
            }
        }

        return $dataTableColumns;
    }

    public function rollback()
    {
        ($del_path = $this->rollbackFile($this->path, $this->fileName)) ? $this->commandData->commandComment($del_path) : false;

        if ($this->commandData->getAddOn('datatables')) {
            if ($this->rollbackFile(
                $this->commandData->config->pathDataTables,
                $this->commandData->modelName.'DataTable.php'
            )) {
                $this->commandData->commandComment('- '.$this->path.$this->fileName);
            }
        }
    }
}

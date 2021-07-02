<?php

namespace Delosfei\Generator\Generators;

use File;
use Illuminate\Support\Str;
use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Utils\FileUtil;
use SplFileInfo;

class MigrationGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    public function __construct($commandData)
    {
        $this->commandData = $commandData;
        $this->path = config('delosfei.generator.path.migration', database_path('migrations/'));
    }

    public function generate()
    {
        $templateData = get_template('migration', 'generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace('$FIELDS$', $this->generateFields(), $templateData);

        $tableName = $this->commandData->dynamicVars['$TABLE_NAME$'];

        $fileName = date('Y_m_d_His').'_'.'create_'.strtolower($tableName).'_table.php';
        $migrate_file = 'create_'.strtolower($tableName).'_table.php';


        if ($this->migrate_file_is_exist($this->path, $migrate_file) && !$this->commandData->commandObj->confirmOverwrite($migrate_file)) {
            return;
        }

        FileUtil::createFile($this->path, $fileName, $templateData);

        $this->commandData->commandInfo('+ '.$this->path.$fileName);
    }

    private function generateFields()
    {
        $fields = [];
        $foreignKeys = [];
        $createdAtField = null;
        $updatedAtField = null;

        foreach ($this->commandData->fields as $field) {
            if ($field->name == 'created_at') {
                $createdAtField = $field;
                continue;
            } else {
                if ($field->name == 'updated_at') {
                    $updatedAtField = $field;
                    continue;
                }
            }

            $fields[] = $field->migrationText;
            if (!empty($field->foreignKeyText)) {
                $foreignKeys[] = $field->foreignKeyText;
            }
        }

        if ($createdAtField and $updatedAtField) {
            $fields[] = '$table->timestamps();';
        } else {
            if ($createdAtField) {
                $fields[] = $createdAtField->migrationText;
            }
            if ($updatedAtField) {
                $fields[] = $updatedAtField->migrationText;
            }
        }

        if ($this->commandData->getOption('softDelete')) {
            $fields[] = '$table->softDeletes();';
        }

        return implode(infy_nl_tab(1, 3), array_merge($fields, $foreignKeys));
    }

    public function rollback()
    {
        $migrate_file = 'create_'.$this->commandData->config->tableName.'_table.php';
        $file = $this->migrate_file_is_exist($this->path, $migrate_file);
        if ($file) {
            if ($this->rollbackFile($this->path, $file)) {
                $this->commandData->commandInfo('- '.$this->path.$file);

            }
        }
    }

    public function migrate_file_is_exist($path, $migrate_file)
    {

        $allFiles = File::allFiles($path);

        $files = [];

        foreach ($allFiles as $file) {
            $files[] = $file->getFilename();
        }

        $files = array_reverse($files);

        foreach ($files as $file) {
            if (Str::contains($file, $migrate_file)) {
                return $file;
            }
        }
    }

}

<?php

namespace Delosfei\Generator\Generators\API;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;
use Illuminate\Support\Str;

class APIRequestGenerator extends BaseGenerator
{
    /**
     * Fields not included in the generator by default.
     *
     * @var array
     */
    protected $excluded_fields = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $FileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathApiRequest;
        $this->FileName = $this->commandData->modelName.'Request.php';
    }

    public function generate()
    {
        $this->generateRequest();
    }

    private function generateRequest()
    {
        $rules = $this->generateRules();
        $attributes = $this->generateAttributes();
        $templateData = get_template('api.request.create_request', 'generator');
        $templateData = str_replace('$RULES$', implode(','.infy_nl_tab(1, 5), $rules), $templateData);
        $templateData = str_replace('$UPDATE_RULES$', implode(','.infy_nl_tab(1, 5), $rules), $templateData);
        $templateData = str_replace('$ATTRIBUTES$', implode(','.infy_nl_tab(1, 3), $attributes), $templateData);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        if (file_exists($this->path.$this->FileName) && !$this->commandData->commandObj->confirmOverwrite($this->FileName)) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->path, $this->FileName, $templateData));

    }


    private function generateRules()
    {
        $dont_require_fields = config('delosfei.generator.options.hidden_fields', [])
            + config('delosfei.generator.options.excluded_fields', $this->excluded_fields);

        $rules = [];

        foreach ($this->commandData->fields as $field) {
            if (!$field->isPrimary && !in_array($field->name, $dont_require_fields)) {
                if ($field->isNotNull && empty($field->validations)) {
                    $field->validations = 'required';
                }

                /**
                 * Generate some sane defaults based on the field type if we
                 * are generating from a database table.
                 */
                if ($this->commandData->getOption('fromTable')) {
                    $rule = empty($field->validations) ? [] : explode('|', $field->validations);

                    if (!$field->isNotNull) {
                        $rule[] = 'nullable';
                    }

                    switch ($field->fieldType) {
                        case 'integer':
                            $rule[] = 'integer';
                            break;
                        case 'boolean':
                            $rule[] = 'boolean';
                            break;
                        case 'float':
                        case 'double':
                        case 'decimal':
                            $rule[] = 'numeric';
                            break;
                        case 'string':
                            $rule[] = 'string';

                            // Enforce a maximum string length if possible.
                            foreach (explode(':', $field->dbInput) as $key => $value) {
                                if (preg_match('/string,(\d+)/', $value, $matches)) {
                                    $rule[] = 'max:'.$matches[1];
                                }
                            }
                            break;
                        case 'text':
                            $rule[] = 'string';
                            break;
                    }

                    $field->validations = implode('|', $rule);
                }
            }

            if (!empty($field->validations)) {
                if (Str::contains($field->validations, 'unique')) {
                    $rule = explode('|', $field->validations);
                    // move unique rule to last
                    usort(
                        $rule,
                        function ($record) {
                            return (Str::contains($record, 'unique')) ? 1 : 0;
                        }
                    );

                    array_pop($rule);

                    $field->validations = implode('|', $rule);
                    $field->validations=str_replace('|',"','" ,$field->validations);
                    $rule = "'".$field->name."' => ['".$field->validations."' ,".$this->generateUniqueRules()."]";
                }else{
                    $field->validations=str_replace('|',"','" ,$field->validations);
                    $rule = "'".$field->name."' => ['".$field->validations."']";
                }



                $rules[] = $rule;
            }
        }

        return $rules;
    }

    public function generateUniqueRules()
    {
        $tableNamePlural = Str::plural($this->commandData->config->tableName);

        return "Rule::unique('".$tableNamePlural."')->ignore(request('id'))";
    }

    private function generateAttributes()
    {
        $dont_require_fields = config('delosfei.generator.options.hidden_fields', [])
            + config('delosfei.generator.options.excluded_fields', $this->excluded_fields);

        $attributes = [];

        foreach ($this->commandData->fields as $field) {
            if (!$field->isPrimary && !in_array($field->name, $dont_require_fields)) {
                $attribute = "'".$field->name."' => '".$field->title."'";
                $attributes[] = $attribute;
            }
        }

        return $attributes;
    }

    public function rollback()
    {
        ($del_path = $this->rollbackFile($this->path, $this->FileName)) ? $this->commandData->commandComment($del_path) : false;
    }
}

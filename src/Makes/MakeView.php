<?php


namespace Delosfei\Generator\Makes;

use Delosfei\Generator\Migrations\SchemaParser;

class MakeView
{
    use MakerTrait;

    protected function getSchemaArray()
    {
        // ToDo - schema is required?
        if ($this->scaffoldCommandObj->option('schema') != null) {
            if ($schema = $this->scaffoldCommandObj->option('schema')) {
                return (new SchemaParser)->parse($schema);
            }
        }

        return [];
    }


    private function start()
    {
        $this->scaffoldCommandObj->line("\n--- Views ---");

        $viewsFiles = $this->getStubViews($this->scaffoldCommandObj->getMeta()['ui']);
        $destination = $this->scaffoldCommandObj->getObjName('views_path');
        $metas = $this->scaffoldCommandObj->getMeta();

        $metas = array_merge_recursive
        (
            $metas,
            [
                'form_fields_fillable' => $this->getFields($metas['ui'], 'fillable'),
                'form_fields_empty' => $this->getFields($metas['ui'], 'fillable'),
                'form_fields_show' => $this->getFields($metas['ui'], 'show'),
                'table_fields_header' => $this->getFields($metas['ui'], 'header'),
                'table_fields_content' => $this->getFields($metas['ui'], 'content'),
            ]
        );

        foreach ($viewsFiles as $viewFileBaseName => $viewFile) {
            $viewFileName = str_replace('.stub', '', $viewFileBaseName);
            $viewDestination = $destination.$viewFileName;

            if ($this->files->exists($viewDestination)) {
                $this->scaffoldCommandObj->comment("   x $viewDestination");
                continue;
            }

            $stub = $this->files->get($viewFile);
            $stub = $this->buildStub($metas, $stub);

            $this->makeDirectory($viewDestination);
            $this->files->put($viewDestination, $stub);
            $this->scaffoldCommandObj->info("   + $viewDestination");
        }
    }

    protected function getFields($ui, $type)
    {
        $stubsFields = $this->getStubFields($ui, $type);
        $stubsFieldsAllow = array_keys($stubsFields);
        $schemas = $this->getSchemaArray();
        $metas = $this->scaffoldCommandObj->getMeta();

        $stubs = [];

        foreach ($schemas as $schema) {
            $variablesFromField = $this->getVariablesFromField($schema);
            $fieldType = $variablesFromField['field.type'];

            if (!in_array($fieldType, $stubsFieldsAllow)) {
                $fieldType = 'default';
            }

            $stub = $stubsFields[$fieldType];
            $stub = $this->buildStub($variablesFromField, $stub);
            $stub = $this->buildStub($metas, $stub);

            $stubs[] = $stub;
        }

        return join(' ', $stubs);
    }

    private function getVariablesFromField($options)
    {
        $data = [];

        $data['field.name'] = $options['name'];
        $data['field.Name'] = ucwords($options['name']);
        $data['field.type'] = @$options['type'];
        $data['field.value.default'] = @$options['options']['default'];

        return $data;
    }
}

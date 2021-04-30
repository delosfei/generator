<?php

namespace App\Console\Makes\Code;


class MakeView
{
    use MakerTrait;

    private function start()
    {
        $this->scaffoldCommandObj->line("\n--- Views ---");

        $dirname = $this->scaffoldCommandObj->getObjName('dirname');
        $name = strtolower($this->scaffoldCommandObj->getObjName('name'));
        $name = $dirname.'/'.$name.'/'.'Index';
        $path = $this->getPath($name, 'vue-index');

        $viewsFiles = $this->getStubViews($this->scaffoldCommandObj->getMeta()['ui']);
        $destination = dirname($path)."/";
        $metas = $this->scaffoldCommandObj->getMeta();

        $metas = array_merge_recursive
        (
            $metas,
            [
                'columns_fields_data' => $this->getFields($metas['ui'], 'data'),
                'form_fields_data' => $this->getFields($metas['ui'], 'form_data'),
                'form_fields_fillable' => $this->getFields($metas['ui'], 'fillable'),

//                'form_fields_show' => $this->getFields($metas['ui'], 'show'),
//                'table_fields_header' => $this->getFields($metas['ui'], 'header'),
//
//                'table_fields_content' => $this->getFields($metas['ui'], 'content'),
            ]
        );

        print_r($metas);
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

        //print_r($stubsFields);

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

        return join('    ', $stubs);
    }

    private function getVariablesFromField($options)
    {
        $data = [];

        $data['field.name'] = $options['name'];
        $data['field.Name'] = ucwords($options['name']);
        $data['field.type'] = @$options['type'];
        $data['field.options.comment'] = @$options['options']['comment'];
        $data['field.value.default'] = @$options['options']['default'];

        return $data;
    }

}

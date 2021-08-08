<?php

namespace Delosfei\Generator\Generators\Scaffold;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;
use Delosfei\Generator\Generators\ViewServiceProviderGenerator;
use Delosfei\Generator\Utils\HTMLFieldGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ViewGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $templateType;

    /** @var array */
    private $htmlFields;
    /**
     * @var mixed|string
     */
    private $vueName;
    /**
     * @var string
     */
    private $vueLayoutName;
    /**
     * @var string
     */
    private $vuePath;
    /**
     * @var string
     */
    private $vueLayoutPath;
    /**
     * @var string
     */
    private $tabsFieldData;
    /**
     * @var string
     */
    private $layoutVueNamePath;
    /**
     * @var array|string|string[]
     */
    private $layoutVueName;

    /**
     * @var string
     */

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathVueViews;
        $this->templateType = config('delosfei.generator.templates', 'dsvue2-templates');
        if ($this->commandData->getOption('vuePrefix')) {
            //如果有vuePrefix参数，分隔参数，作为layout组件名，和vue文件路径
            $vuePrefix = $this->commandData->getOption('vuePrefix');
            $vuePrefix = explode('/', $vuePrefix);
            $this->vueName = (count($vuePrefix) > 1 ? $vuePrefix[1] : $this->commandData->config->mCamel);
            $this->vueLayoutName = strtolower($vuePrefix[0]);
            $this->layoutVueNamePath = strtolower($this->vueLayoutName.'/'.$this->vueName.'/');
        } else {
            //如果没有vuePrefix参数，取模型名称，作为layout组件名，和vue文件路径
            $this->vueLayoutName = strtolower($this->commandData->config->mName);
            $this->layoutVueNamePath = strtolower($this->vueLayoutName.'/'.$this->vueLayoutName.'/');
        }
        $this->vueLayoutPath = $this->path.'layouts/';
        $this->vuePath = $this->path.'views/'.$this->layoutVueNamePath;
        $this->layoutVueName = str_replace('/', '.', $this->layoutVueNamePath);
    }

    public function generate()
    {
        if (!file_exists($this->vueLayoutPath)) {
            mkdir($this->vueLayoutPath, 0755, true);
        }

        if (!file_exists($this->vuePath)) {
            mkdir($this->vuePath, 0755, true);
        }

        $htmlInputs = Arr::pluck($this->commandData->fields, 'htmlInput');
        if (in_array('file', $htmlInputs)) {
            $this->commandData->addDynamicVariable('$FILES$', ", 'files' => true");
        }

        $this->commandData->commandInfo("\nGenerating Views...");

        $this->generateLayout();

        if ($this->commandData->getOption('views')) {
            $viewsToBeGenerated = explode(',', $this->commandData->getOption('views'));

            if (in_array('index', $viewsToBeGenerated)) {
                $this->generateIndex();
            }

            if (count(array_intersect(['create', 'update'], $viewsToBeGenerated)) > 0) {
                $this->generateForm();
            }

            if (in_array('create', $viewsToBeGenerated)) {
                $this->generateCreate();
            }

            if (in_array('edit', $viewsToBeGenerated)) {
                $this->generateUpdate();
            }

            if (in_array('show', $viewsToBeGenerated)) {
                $this->generateShowFields();
                $this->generateShow();
            }
        } else {
            $this->generateIndex();
            $this->generateForm();
            $this->generateCreate();
            $this->generateUpdate();
            $this->generateShowFields();
            $this->generateShow();
        }
        $this->generateTabsJs();
        $this->commandData->commandInfo('Views created: ');
    }

    private function generateLayout()
    {
        $templateName = 'ds_layout';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        if (file_exists($this->vueLayoutPath.$this->vueLayoutName.'.vue') && !$this->commandData->commandObj->confirmOverwrite(
                $this->vueLayoutName.'.vue'
            )) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->vueLayoutPath, $this->vueLayoutName.'.vue', $templateData));

    }

    private function generateTabsJs()
    {
        $templateName = 'ds_tabs_js';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace(
            '$FIELDS$',
            $this->tabsFieldData,
            $templateData
        );


        if (file_exists($this->vuePath.'tabs.js') && !$this->commandData->commandObj->confirmOverwrite('tabs.js')) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->vuePath, 'tabs.js', $templateData));


    }

    private function generateIndex()
    {
        //写进tabs.js文件，加入导航
        $this->tabsFieldData .= infy_tab(4)."{ title: '会员组列表', name: '".$this->layoutVueName."index' },";

        $templateName = 'ds_index';
        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);
        $this->commandData->addDynamicVariable('$EL_TABLE_FIELDS$', $this->generateIndexFields());
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        if (file_exists($this->vuePath.'index.vue') && !$this->commandData->commandObj->confirmOverwrite('index.vue')) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->vuePath, 'index.vue', $templateData));
    }

    private function generateForm()
    {
        $templateName = 'ds_form';
        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);
        $this->commandData->addDynamicVariable('$EL_FORM_FIELDS$', $this->generateFormFields());
        $this->commandData->addDynamicVariable('$FORM_FIELDS_NAME$', $this->generateFormFieldsName());
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        if (file_exists($this->vuePath.'form.vue') && !$this->commandData->commandObj->confirmOverwrite('form.vue')) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->vuePath, 'form.vue', $templateData));
    }

    private function generateFormFields(): string
    {

        $this->htmlFields = [];
        $fieldTemplate = '\n';
        foreach ($this->commandData->fields as $field) {
            if (!$field->inForm) {
                continue;
            }
            $validations = explode('|', $field->validations);
            $minMaxRules = '';
            foreach ($validations as $validation) {
                if (!Str::contains($validation, ['max:', 'min:'])) {
                    continue;
                }

                $validationText = substr($validation, 0, 3);
                $sizeInNumber = substr($validation, 4);

                $sizeText = ($validationText == 'min') ? 'minlength' : 'maxlength';
                if ($field->htmlType == 'number') {
                    $sizeText = $validationText;
                }

                $size = ",'$sizeText' => $sizeInNumber";
                $minMaxRules .= $size;
            }
            $this->commandData->addDynamicVariable('$SIZE$', $minMaxRules);

            $fieldTemplate .= infy_nl_tab(1, 4).HTMLFieldGenerator::generateHTML($field, $this->templateType, false);

            if ($field->htmlType == 'selectTable') {
                $inputArr = explode(',', $field->htmlValues[1]);
                $columns = '';
                foreach ($inputArr as $item) {
                    $columns .= "'$item'".',';  //e.g 'email,id,'
                }
                $columns = substr_replace($columns, '', -1); // remove last ,

                $htmlValues = explode(',', $field->htmlValues[0]);
                $selectTable = $htmlValues[0];
                $modalName = null;
                if (count($htmlValues) == 2) {
                    $modalName = $htmlValues[1];
                }

                $tableName = $this->commandData->config->tableName;
                $viewPath = $this->commandData->config->prefixes['view'];
                if (!empty($viewPath)) {
                    $tableName = $viewPath.'.'.$tableName;
                }

                $variableName = Str::singular($selectTable).'Items'; // e.g $userItems
                $fieldTemplateSb = $this->generateViewComposer($tableName, $variableName, $columns, $selectTable, $modalName);
            }

            if (!empty($fieldTemplateSb)) {
                $fieldTemplate .= $fieldTemplateSb;
            }
        }

        return $fieldTemplate;
    }

    private function generateFormFieldsName(): string
    {
        $formFieldsName = '';
        foreach ($this->commandData->fields as $field) {
            if (!$field->inForm) {
                continue;
            }
            $formFieldsName .= $field->name.": '',";
        }

        return $formFieldsName;
    }

    private function generateViewComposer($tableName, $variableName, $columns, $selectTable, $modelName = null)
    {
        $templateName = 'scaffold.fields.select';

        $fieldTemplate = get_template($templateName, $this->templateType);

        $viewServiceProvider = new ViewServiceProviderGenerator($this->commandData);
        $viewServiceProvider->generate();
        $viewServiceProvider->addViewVariables($tableName.'.fields', $variableName, $columns, $selectTable, $modelName);

        $fieldTemplate = str_replace(
            '$INPUT_ARR$',
            '$'.$variableName,
            $fieldTemplate
        );

        return $fieldTemplate;
    }

    private function generateCreate()
    {
        //写进tabs.js文件，加入导航
        $this->tabsFieldData .= infy_nl_tab(1, 1)."{ title: '添加会员组', name: '".$this->layoutVueName."create' },";

        $templateName = 'ds_create';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);


        if (file_exists($this->vuePath.'create.vue') && !$this->commandData->commandObj->confirmOverwrite('create.vue')) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->vuePath, 'create.vue', $templateData));

    }

    private function generateUpdate()
    {
        //写进tabs.js文件，加入导航
        $this->tabsFieldData .= infy_nl_tab(1, 1)."{ title: '修改会员组', name: '".$this->layoutVueName."edit', current: true },";

        $templateName = 'ds_edit';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        if (file_exists($this->vuePath.'edit.vue') && !$this->commandData->commandObj->confirmOverwrite('edit.vue')) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->vuePath, 'edit.vue', $templateData));

    }

    private function generateIndexFields(): string
    {
        $templateName = 'ds_index_field';
        $fieldTemplate = get_template('scaffold.views.'.$templateName, $this->templateType);

        $fieldsStr = '';
        foreach ($this->commandData->fields as $field) {
            if (!$field->inIndex) {
                continue;
            }
            $singleFieldStr = str_replace('$FIELD_TITLE$', Str::title(str_replace('_', ' ', $field->title)), $fieldTemplate);
            $singleFieldStr = str_replace('$FIELD_NAME$', $field->name, $singleFieldStr);
            $singleFieldStr = str_replace('$FIELD_TITLE$', $field->title, $singleFieldStr);
            $singleFieldStr = fill_template($this->commandData->dynamicVars, $singleFieldStr);
            $fieldsStr .= infy_nl_tab().$singleFieldStr;
        }

        return $fieldsStr;
    }

    private function generateShow()
    {
        $templateName = 'ds_show';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        if (file_exists($this->vuePath.'show.vue') && !$this->commandData->commandObj->confirmOverwrite('show.vue')) {
            return;
        }
        $this->commandData->commandComment($this->createFileAndShowInfo($this->vuePath, 'show.vue', $templateData));
    }

    public function rollback($views = [])
    {
        $files = [

            'tabs.js',
            'index.vue',
            'form.vue',
            'create.vue',
            'edit.vue',
            'show.vue',
        ];

        if (!empty($views)) {
            $files = ['tabs.js'];
            foreach ($views as $view) {
                $files[] = $view.'.vue';
            }
        }

        foreach ($files as $file) {
            ($del_path = $this->rollbackFile($this->vuePath, $file)) ? $this->commandData->commandComment($del_path) : false;
        }
        @rmdir($this->vuePath);
        if (@rmdir($this->path.'views/'.strtolower($this->vueLayoutName.'/'))) {
            ($del_path = $this->rollbackFile($this->vueLayoutPath, $this->vueLayoutName.'.vue')) ? $this->commandData->commandComment($del_path) : false;
        }
    }
}

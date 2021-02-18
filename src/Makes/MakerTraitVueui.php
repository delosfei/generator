<?php

namespace Delosfei\Generator\Makes;

use Delosfei\Generator\Commands\MakeVueuiCommand;
use Illuminate\Filesystem\Filesystem;

trait MakerTraitVueui
{
    protected $files;
    protected $scaffoldCommandObj;

    public function __construct(MakeVueuiCommand $scaffoldCommand, Filesystem $files)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;
        $this->start();
    }

    protected function getArrayRecursive(array $array, $parent = '')
    {
        $data = [];

        foreach ($array as $key => $value) {
            if (gettype($value) == 'array') {
                array_merge(
                    $data,
                    $this->getArrayRecursive($value, "$parent")
                );
                continue;
            }

            $data["$parent.$key"] = $value;
        }

        return $data;
    }


    protected function getFilesRecursive($path)
    {
        $files = [];
        $scan = array_diff(scandir($path), ['.', '..']);

        foreach ($scan as $file) {
            $file = realpath("$path$file");

            if (is_dir($file)) {
                $files = array_merge
                (
                    $files,
                    $this->getFilesRecursive($file.DIRECTORY_SEPARATOR)
                );
                continue;
            }

            $files[] = $file;
        }

        return $files;
    }


    protected function getStubPath()
    {
        return substr(__DIR__, 0, -5).'Stubs'.DIRECTORY_SEPARATOR;
    }


    protected function getStubFields($ui, $type)
    {
        $stubsFieldsPath = $this->getStubPath().join(DIRECTORY_SEPARATOR, ['views', $ui, 'fields', $type, '']);

        if ($this->existsDirectory($stubsFieldsPath)) {
            $this->scaffoldCommandObj->error('Stub not found');

            return;
        }

        $stubsFieldsFiles = $this->getFilesRecursive($stubsFieldsPath);

        $stubs = [];

        foreach ($stubsFieldsFiles as $file) {
            $stubs[str_replace($stubsFieldsPath, '', $file)] = $this->getFile($file);
        }

        return $stubs;
    }

    protected function getStubViews($ui)
    {
        $viewsPath = $this->getStubPath().join(DIRECTORY_SEPARATOR, ['views', $ui, 'pages', '']);
        $files = $this->getFilesRecursive($viewsPath);
        $viewFiles = [];

        foreach ($files as $file) {
            $viewFiles[str_replace($viewsPath, '', $file)] = $file;
        }

        return $viewFiles;
    }

    protected function buildStub(array $metas, &$template)
    {
        foreach ($metas as $k => $v) {
            $template = str_replace("{{".$k."}}", $v, $template);
        }

        return $template;
    }


    protected function getPath($file_name, $path = 'vue-layout')
    {
        if ($path == "vue-layout") {
            return 'vue/layouts/'.$file_name.'.vue';
        } elseif ($path == "vue-tabs") {
            return 'vue/views/'.$file_name.'.js';
        }elseif ($path == "vue-edit" || $path == "vue-create" || $path == "vue-form" || $path == "vue-index") {
            return 'vue/views/'.$file_name.'.vue';
        }
    }

    protected function getFile($file)
    {
        return $this->files->get($file);
    }

    protected function existsDirectory($path)
    {
        return !$this->files->isDirectory($path);
    }


    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    protected function compileStub($filename)
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5).'Stubs/'.$filename.'.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);

        // $this->replaceValidator($stub);

        return $stub;
    }

    protected function compileViewStub($filename)
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5).'Stubs/views/vue/'.$filename.'.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);


        return $stub;
    }

}

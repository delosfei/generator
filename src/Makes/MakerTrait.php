<?php

namespace Delosfei\Generator\Makes;

use Delosfei\Generator\Commands\MakeCodeCommand;
use Illuminate\Filesystem\Filesystem;

trait MakerTrait
{
    protected $files;
    protected $scaffoldCommandObj;
    public function __construct(MakeCodeCommand $scaffoldCommand, Filesystem $files)
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


    protected function getPath($file_name, $path = 'controller')
    {
        $namespace_app = $this->scaffoldCommandObj->getObjName('namespace_name_app');
        $namespace_gen = $this->scaffoldCommandObj->getObjName('namespace_name_gen');
        $database_path = $this->scaffoldCommandObj->getObjName('database_path');


        if ($path == "controller") {
            return $namespace_app.'Http/Controllers/'.$file_name.'.php';
        } elseif ($path == "request") {
            return $namespace_app.'Http/Requests/'.$file_name.'.php';
        } elseif ($path == "observer") {
            return $namespace_app.'Observers/'.$file_name.'.php';
        } elseif ($path == "policy") {
            return $namespace_app.'Policies/'.$file_name.'.php';
        } elseif ($path == "factory") {
            return $database_path.'factories/'.$file_name.'Factory.php';
        } elseif ($path == "model") {
            return $namespace_app.'Models/'.$file_name.'.php';
        } elseif ($path == "model-trait") {
            return $namespace_app.'Models/Traits/'.$file_name.'Operation.php';
        } elseif ($path == "seed") {
            return $database_path.'seeders/'.$file_name.'.php';
        } elseif ($path == "view-index") {
            return $namespace_gen.'resources/views/'.$file_name.'/index.blade.php';
        } elseif ($path == "view-edit") {
            return $namespace_gen.'resources/views/'.$file_name.'/edit.blade.php';
        } elseif ($path == "view-show") {
            return $namespace_gen.'resources/views/'.$file_name.'/show.blade.php';
        } elseif ($path == "view-create") {
            return $namespace_gen.'resources/views/'.$file_name.'/create.blade.php';
        } elseif ($path == "localization") {
            return $namespace_gen.'resources/lang/'.$file_name.'.php';
        } elseif ($path == "route") {
            return $namespace_gen.'routes/web.php';
        } elseif ($path == "route_old") {
            return $namespace_app.'Http/routes.php';
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


}

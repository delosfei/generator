<?php

namespace App\Console\Makes\Services;

use App\Console\Commands\MakeServicesCommand;
use Illuminate\Filesystem\Filesystem;

trait MakerTraitServices
{
    protected $files;
    protected $scaffoldCommandObj;

    public function __construct(MakeServicesCommand $scaffoldCommand, Filesystem $files)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;
        $this->start();
    }

    protected function getStubPath()
    {
        return dirname(__DIR__, 2).'/Stubs/Services'.DIRECTORY_SEPARATOR;
    }

    protected function getPath($file_name, $path = 'services')
    {
        if ($path == "facade" || $path == "services" || $path == "service-provider") {
            return 'App/Services/'.$this->scaffoldCommandObj->getObjName('Name').'/'.$file_name.'.php';
        }

    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    protected function compileStub($filename)
    {
        $stub = $this->files->get($this->getStubPath().$filename.'.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);

        return $stub;
    }

    protected function buildStub(array $metas, &$template)
    {
        foreach ($metas as $k => $v) {
            $template = str_replace("{{".$k."}}", $v, $template);
        }

        return $template;
    }
}

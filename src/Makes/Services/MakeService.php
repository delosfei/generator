<?php

namespace App\Console\Makes\Services;

class MakeService
{
    use MakerTraitServices;

    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name') . 'Service';
        $path = $this->getPath($name,'services');
        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub('service'));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }

}

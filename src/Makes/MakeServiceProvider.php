<?php

namespace Delosfei\Generator\Makes;

class MakeServiceProvider
{
    use MakerTrait;

    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name') . 'ServiceProvider';
        $path = $this->getPath($name);
        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub('service-provider'));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }

}

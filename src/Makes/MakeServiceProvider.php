<?php

namespace Delosfei\Generator\Makes;

class MakeServiceProvider
{
    use MakerTraitServices;

    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name') . 'ServiceProvider';
        $path = $this->getPath($name,'service-provider');
        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub('service-provider'));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }

}

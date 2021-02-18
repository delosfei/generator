<?php

namespace Delosfei\Generator\Makes;

class MakeFacade
{
    use MakerTraitServices;

    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name') . 'Facade';
        $path = $this->getPath($name,'facade');
        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub('facade'));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }

}

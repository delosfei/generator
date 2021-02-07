<?php

namespace Delosfei\Generator\Makes;

class MakeFormRequest
{
    use MakerTrait;

    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name');
        $this->makeRequest('Request', 'request');
        $this->makeRequest($name . 'Request', 'request_model');
    }

    protected function makeRequest($name, $stubname)
    {
        $path = $this->getPath($name, 'request');

        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x $path" . ' (Skipped)');
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub($stubname));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }




}

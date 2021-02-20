<?php

namespace Delosfei\Generator\Makes\Code;



class MakeController
{
    use MakerTrait;

    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name') . 'Controller';
        $path = $this->getPath($name, 'controller-api');
        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileControllerStub());

        $this->scaffoldCommandObj->info('+ ' . $path);
    }


    protected function compileControllerStub()
    {


        $stub = $this->files->get($this->getStubPath() . 'controller-api.stub');


        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);
        // $this->replaceValidator($stub);

        return $stub;
    }





}

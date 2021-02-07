<?php

namespace Delosfei\Generator\Makes;



class MakeController
{
    use MakerTrait;

    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Names') . 'Controller';
        $path = $this->getPath($name, 'controller');
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


        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/controller.stub');


        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);
        // $this->replaceValidator($stub);

        return $stub;
    }





}

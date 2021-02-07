<?php

namespace Delosfei\Generator\Makes;


class MakeLayout
{
    use MakerTrait;


    protected function start()
    {
        $ui = $this->scaffoldCommandObj->getMeta()['ui'];
        $this->putViewLayout("Stubs/views/$ui/layout.blade.php.stub", 'layouts/app.blade.php');
        $this->putViewLayout("Stubs/views/$ui/error.blade.php.stub", 'common/error.blade.php');
    }



    protected function putViewLayout($stub, $file)
    {
        $path_file = $this->scaffoldCommandObj->getObjName('views_path').$file;
        $path_stub = substr(__DIR__,0, -5) .$stub;

        $this->makeDirectory($path_file);

        if ($this->files->exists($path_file))
        {
            return $this->scaffoldCommandObj->comment("   x $path_file");
        }

        $html = $this->files->get($path_stub);
        $html = $this->buildStub($this->scaffoldCommandObj->getMeta(), $html);
        $this->files->put($path_file, $html);
        $this->scaffoldCommandObj->info("   + $path_file");
    }

}

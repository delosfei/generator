<?php

namespace App\Console\Makes\Code;


class MakeLayout
{
    use MakerTrait;


    protected function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Dirname').'Layout';
        $ui = $this->scaffoldCommandObj->getMeta()['ui'];
        $module = $this->scaffoldCommandObj->getObjName('module');
        $layout = empty($module) ? 'layout' : 'layout_module';

        $path_stub = dirname(__DIR__, 2)."/Stubs/Code/views/".$layout.".vue.stub";
        $path = $this->getPath($name, 'vue-layout');
        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("   x ".$path);
        }

        $this->makeDirectory($path);
        $html = $this->files->get($path_stub);
        $html = $this->buildStub($this->scaffoldCommandObj->getMeta(), $html);
        $this->files->put($path, $html);
        $this->scaffoldCommandObj->info("   + $path");
    }


}

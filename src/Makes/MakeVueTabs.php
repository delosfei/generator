<?php

namespace Delosfei\Generator\Makes;

class MakeVueTabs
{
    use MakerTrait;

    private function start()
    {
        $dirname = $this->scaffoldCommandObj->getObjName('dirname');
        $cname = strtolower($this->scaffoldCommandObj->getObjName('Name'));
        $name = $dirname.'/'.$cname.'/'.'tabs';

        $path = $this->getPath($name, 'vue-tab');
        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("x ".$path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileViewStub('layout.vue'));

        $this->scaffoldCommandObj->info('+ '.$path);
    }

}

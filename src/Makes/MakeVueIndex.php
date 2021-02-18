<?php

namespace Delosfei\Generator\Makes;

class MakeVueIndex
{
    use MakerTrait;

    private function start()
    {
        $dirname = $this->scaffoldCommandObj->getObjName('dirname');
        $cname = strtolower($this->scaffoldCommandObj->getObjName('Name'));
        $name = $dirname.'/'.$cname.'/'.'Index';

        $path = $this->getPath($name, 'vue-index');
        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("x ".$path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileViewStub('index.vue'));

        $this->scaffoldCommandObj->info('+ '.$path);
    }

}

<?php

namespace Delosfei\Generator\Makes;

class MakeVueCreate
{
    use MakerTrait;

    private function start()
    {
        $dirname = $this->scaffoldCommandObj->getObjName('dirname');
        $cname = strtolower($this->scaffoldCommandObj->getObjName('Name'));
        $name = $dirname.'/'.$cname.'/'.'Create';

        $path = $this->getPath($name, 'vue-create');
        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("x ".$path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileViewStub('create.vue'));

        $this->scaffoldCommandObj->info('+ '.$path);
    }

}

<?php

namespace Delosfei\Generator\Makes\Vueui;


class MakeVueCreate
{
    use MakerTraitVueui;

    private function start()
    {
        $dirname = $this->scaffoldCommandObj->getObjName('dirname');
        $cname = $this->scaffoldCommandObj->getObjName('name');
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

<?php

namespace Delosfei\Generator\Makes\Vueui;


class MakeVueEdit
{
    use MakerTraitVueui;

    private function start()
    {
        $dirname = $this->scaffoldCommandObj->getObjName('dirname');
        $cname = strtolower($this->scaffoldCommandObj->getObjName('Name'));
        $name = $dirname.'/'.$cname.'/'.'Edit';

        $path = $this->getPath($name, 'vue-edit');
        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("x ".$path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileViewStub('edit.vue'));

        $this->scaffoldCommandObj->info('+ '.$path);
    }

}

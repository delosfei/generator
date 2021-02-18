<?php

namespace Delosfei\Generator\Makes;

class MakeVueForm
{
    use MakerTraitVueui;

    private function start()
    {
        $dirname = $this->scaffoldCommandObj->getObjName('dirname');
        $cname = strtolower($this->scaffoldCommandObj->getObjName('Name'));
        $name = $dirname.'/'.$cname.'/'.'Form';

        $path = $this->getPath($name, 'vue-form');
        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("x ".$path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileViewStub('form.vue'));

        $this->scaffoldCommandObj->info('+ '.$path);
    }

}

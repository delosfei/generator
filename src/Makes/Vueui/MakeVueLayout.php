<?php

namespace Delosfei\Generator\Makes\Vueui;


class MakeVueLayout
{
    use MakerTraitVueui;

    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name') . 'Layout';
        $path = $this->getPath($name,'vue-layout');
        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileViewStub('layout.vue'));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }

}

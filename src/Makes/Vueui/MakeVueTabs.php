<?php

namespace Delosfei\Generator\Makes\Vueui;


class MakeVueTabs
{
    use MakerTraitVueui;

    private function start()
    {
        $dirname = $this->scaffoldCommandObj->getObjName('dirname');
        $cname = strtolower($this->scaffoldCommandObj->getObjName('Name'));
        $name = $dirname.'/'.$cname.'/'.'tabs';

        $path = $this->getPath($name, 'vue-tabs');
        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("x ".$path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileViewStub('tabs.js'));

        $this->scaffoldCommandObj->info('+ '.$path);
    }

}

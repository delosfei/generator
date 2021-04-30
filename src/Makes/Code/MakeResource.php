<?php


namespace App\Console\Makes\Code;


class MakeResource
{
    use MakerTrait;
    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name');
        $resource_name = $name . 'Resource';
        $path = $this->getPath($resource_name, 'resource');

        if (!$this->files->exists($path)) {
            $this->makeDirectory($path);
            $this->files->put($path, $this->compileStub('resource'));

            return $this->scaffoldCommandObj->info("+ $path");
        }


        return $this->scaffoldCommandObj->comment("x $path" . ' (Skipped)');
    }
}

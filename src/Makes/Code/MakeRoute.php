<?php


namespace App\Console\Makes\Code;


class MakeRoute
{
    use MakerTrait;



    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name');
//        $route_name = floatval(app()::VERSION) < 5.3 ? 'route_old' : 'route';
        $route_name = 'route-api';
        $path = $this->getPath($name, $route_name);

        if (!$this->files->exists($path)) {
            $this->makeDirectory($path);
            $this->files->put($path, $this->compileStub($route_name));
        }

        $stub = $this->compileRouteStub();

        if (strpos($this->files->get($path), $stub) === false) {
            $this->files->append($path, $this->compileRouteStub());
            return $this->scaffoldCommandObj->info('+ ' . $path . ' (Updated)');
        }

        return $this->scaffoldCommandObj->comment("x $path" . ' (Skipped)');
    }




    protected function compileRouteStub()
    {
        $stub = $this->files->get($this->getStubPath() . 'route-api.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);

        return $stub;
    }
}

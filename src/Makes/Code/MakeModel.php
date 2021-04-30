<?php


namespace App\Console\Makes\Code;

use App\Console\Migrations\SchemaParser;

class MakeModel
{
    use MakerTrait;


    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name');
        $path = $this->getPath($name, 'model');

        $this->createBaseModelIfNotExists();

        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("x $path");
        }

        $this->files->put($path, $this->compileModelStub());

        $this->scaffoldCommandObj->info('+ '.$path);
    }


    protected function compileModelStub()
    {
        $stub = $this->files->get($this->getStubPath() . 'model.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);
        $this->buildFillable($stub);

        return $stub;
    }


    protected function buildFillable(&$stub)
    {
        $schemaArray = [];

        $schema = $this->scaffoldCommandObj->getMeta()['schema'];

        if ($schema) {
            $items = (new SchemaParser)->parse($schema);
            foreach ($items as $item) {
                $schemaArray[] = "'{$item['name']}'";
            }

            $schemaArray = join(", ", $schemaArray);
        }

        $stub = str_replace('{{fillable}}', $schemaArray, $stub);

        return $this;
    }

    protected function createBaseModelIfNotExists()
    {
        $base_model_path = $this->getPath("Model", 'model');
        if (!$this->files->exists($base_model_path)) {
            $this->makeDirectory($base_model_path);
            $this->files->put($base_model_path, $this->compileBaseModelStub());

            return $this->scaffoldCommandObj->info("+ $base_model_path".' (Updated)');
        }

        return $this->scaffoldCommandObj->comment("x $base_model_path".' (Skipped)');
    }

    protected function compileBaseModelStub()
    {
        $stub = $this->files->get($this->getStubPath() . 'base_model.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);
        $this->buildFillable($stub);

        return $stub;
    }
}

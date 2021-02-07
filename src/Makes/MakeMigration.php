<?php


namespace Delosfei\Generator\Makes;

use Delosfei\Generator\Migrations\SchemaParser;
use Delosfei\Generator\Migrations\SyntaxBuilder;

class MakeMigration
{
    use MakerTrait;
    protected function start(){
        $name = 'create_'.strtolower( str_replace('/','_',$this->scaffoldCommandObj->argument('name'))).'_table';
        $path = $this->getPath($name);

        if ( ! $this->classExists($name))
        {
            $this->makeDirectory($path);
            $this->files->put($path, $this->compileMigrationStub());
            return $this->scaffoldCommandObj->info('+ ' . $path);
        }
        return $this->scaffoldCommandObj->comment('x ' . $path);
    }


    protected function getPath($name)
    {
        return './database/migrations/'.date('Y_m_d_His').'_'.$name.'.php';
    }


    protected function compileMigrationStub()
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/migration.stub');

        $this->replaceSchema($stub);
        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);

        return $stub;
    }


    protected function replaceSchema(&$stub)
    {
        if ($schema = $this->scaffoldCommandObj->getMeta()['schema'])
        {
            $schema = (new SchemaParser())->parse($schema);
        }

        $schema = (new SyntaxBuilder())->create($schema, $this->scaffoldCommandObj->getMeta());
        $stub = str_replace(['{{schema_up}}', '{{schema_down}}'], $schema, $stub);

        return $this;
    }

    public function classExists($name)
    {
        $files = $this->files->allFiles('./database/migrations/');
        foreach ($files as $file) {
            if (strpos($file->getFilename(), $name) !== false) {
                return true;
            }
        }

        return false;
    }
}

<?php

namespace Delosfei\Generator\Makes;


class MakeSeed
{
    use MakerTrait;


    /**
     * Start make seed.
     *
     * @return void
     */
    protected function start()
    {
        $this->generateFactory();
        $this->generateSeed();
        $this->updateDatabaseSeeder();
    }

    protected function generateFactory()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name');
        $path = $this->getPath($name, 'factory');

        if (!$this->files->exists($path)) {
            $this->makeDirectory($path);
            $this->files->put($path, $this->compileStub('factory'));

            return $this->scaffoldCommandObj->info("+ $path");
        }

        return $this->scaffoldCommandObj->comment("x $path");
    }

    protected function generateSeed()
    {
        $path = $this->getPath($this->scaffoldCommandObj->getObjName('Name') . 'Seeder', 'seed');

        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment('x ' . $path);
        }

        $this->makeDirectory($path);
        $this->files->put($path, $this->compileStub('seed'));
        $this->scaffoldCommandObj->info('+ ' . $path);
    }

    protected function updateDatabaseSeeder()
    {
        $seeder_path=$this->scaffoldCommandObj->getObjName('database_path').'seeders/';
        $seeder_name=$this->scaffoldCommandObj->getObjName('seeder_name');

        $path = $seeder_path.$seeder_name;

        $content = $this->files->get($path);
        $name = $this->scaffoldCommandObj->getObjName('Names') . 'Seeder';

        if (strpos($content, $name) === false) {

            $content = str_replace(
                'UserSeeder::class,',
                "UserSeeder::class,\n\t\t\$name::class,",
                $content
            );
            $this->files->put($path, $content);

            return $this->scaffoldCommandObj->info('+ ' . $path . ' (Updated)');
        }

        return $this->scaffoldCommandObj->comment("x " . $path . ' (Skipped)');
    }
}

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
        $path = $this->getPath($this->scaffoldCommandObj->getObjName('Name') . 'TableSeeder', 'seed');

        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment('x ' . $path);
        }

        $this->makeDirectory($path);
        $this->files->put($path, $this->compileStub('seed'));
        $this->scaffoldCommandObj->info('+ ' . $path);
    }

    protected function updateDatabaseSeeder()
    {
        $path = $this->scaffoldCommandObj->getObjName('migrations_path').'seeders/DatabaseSeeder.php';

        $content = $this->files->get($path);
        $name = $this->scaffoldCommandObj->getObjName('Names') . 'TableSeeder';

        if (strpos($content, $name) === false) {

            $content = str_replace(
                '(UsersTableSeeder::class);',
                "(UsersTableSeeder::class);\n\t\t\$this->call($name::class);",
                $content
            );
            $this->files->put($path, $content);

            return $this->scaffoldCommandObj->info('+ ' . $path . ' (Updated)');
        }

        return $this->scaffoldCommandObj->comment("x " . $path . ' (Skipped)');
    }
}

<?php

namespace App\Console\Commands;

use App\Console\Makes\Services\MakeFacade;
use App\Console\Makes\Services\MakerTraitServices;
use App\Console\Makes\Services\MakeService;
use App\Console\Makes\Services\MakeServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeServicesCommand extends Command
{
    use MakerTraitServices;

    protected $signature = 'ds:services { name : the name of service}
                                        {--M|module= : the name of module}
                                        ';

    protected $description = 'Command description';
    protected $meta;
    protected $files;
    private $composer;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        $this->composer = app()['composer'];
    }


    public function handle()
    {
        $header = "scaffolding: {$this->argument("name")}";
        $footer = str_pad('', strlen($header), '-');
        $dump = str_pad('>DUMP AUTOLOAD<', strlen($header), ' ', STR_PAD_BOTH);

        $this->line("\n----------- $header -----------\n");
        $this->makeMeta();
        $this->makeFacade();
        $this->makeService();
        $this->makeServiceProvider();
        $this->updateConfigApp();
        $this->line("\n----------- $footer -----------");
        $this->comment("----------- $dump -----------");
        $this->composer->dumpAutoloads();
    }

    protected function makeMeta()
    {
        $this->meta['Name'] = $this->getObjName('Name');
        $this->meta['Module'] = $this->getObjName('Module');
    }

    /**
     * @throws \Exception
     */
    public function getObjName($config = 'Name')
    {
        $names = [];
        $args_name = $this->argument('name');
        $opts_module_name = $this->option('module');
        // Article
        $names['Name'] = ucfirst($args_name);
        $names['Module'] = ucfirst($opts_module_name);

        if (!isset($names[$config])) {
            throw new \Exception("Position name is not found");
        };

        return $names[$config];
    }


    public function getMeta()
    {
        return $this->meta;
    }

    protected function makeFacade()
    {
        new MakeFacade($this, $this->files);
    }

    protected function makeService()
    {
        new MakeService($this, $this->files);
    }

    protected function makeServiceProvider()
    {
        new MakeServiceProvider($this, $this->files);
    }

    protected function updateConfigApp()
    {
        $path = 'config/app.php';
        $content = $this->files->get($path);
        $name_gen = $this->getObjName('Name');
        $name = $this->getObjName('Name').'ServiceProvider::class';
        if (strpos($content, $name) === false) {
            $content = str_replace(
                ["'providers' => [", "'aliases' => ["],
                [
                    "'providers' => [\n\t\t\\App\Services\\".$name_gen."\\".$name_gen."ServiceProvider::class,",
                    "'aliases' => [\n\t\t'".$name_gen."Service' => \\App\Services\\".$name_gen."\\".$name_gen."Facade::class,",
                ],
                $content
            );
            $this->files->put($path, $content);

            return $this->info('+ '.$path.' (Updated)');
        }
    }
}

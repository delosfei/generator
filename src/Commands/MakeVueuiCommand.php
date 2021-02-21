<?php

namespace Delosfei\Generator\Commands;

use Delosfei\Generator\Makes\Vueui\MakerTraitVueui;
use Delosfei\Generator\Makes\Vueui\MakeVueCreate;
use Delosfei\Generator\Makes\Vueui\MakeVueEdit;
use Delosfei\Generator\Makes\Vueui\MakeVueForm;
use Delosfei\Generator\Makes\Vueui\MakeVueIndex;
use Delosfei\Generator\Makes\Vueui\MakeVueLayout;
use Delosfei\Generator\Makes\Vueui\MakeVueTabs;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Input\InputArgument;

class MakeVueuiCommand extends Command
{
    use MakerTraitVueui;

    // protected $signature = 'ds:code';
    protected $name = 'ds:vueui';
    protected $description = '生成Vue前端代码';
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
        $header = "makevueui: {$this->getObjName("Name")}";
        $footer = str_pad('', strlen($header), '-');
        $dump = str_pad('>DUMP AUTOLOAD<', strlen($header), ' ', STR_PAD_BOTH);

        $this->line("\n----------- $header -----------\n");
        $this->makeMeta();
        $this->makeVueLayout();
        $this->makeVueTabs();
        $this->makeVueCreate();
        $this->makeVueEdit();
        $this->makeVueForm();
        $this->makeVueIndex();

        $this->line("\n----------- $footer -----------");
        $this->comment("----------- $dump -----------");
        $this->composer->dumpAutoloads();
    }

    protected function getArguments()
    {
        return
            [
                ['name', InputArgument::REQUIRED, 'The name of the model. (Ex: User)'],
            ];
    }

    protected function makeMeta()
    {
        $this->meta['dirname'] = $this->getObjName('dirname');
        $this->meta['Name'] = $this->getObjName('Name');
        $this->meta['name'] = $this->getObjName('name');
    }

    public function getObjName($config = 'Name')
    {
        $names = [];
        $args_name = $this->argument('name');

        if (strstr($args_name, '/')) {
            $ex = explode('/', $args_name);
            $names['dirname'] = ucfirst($ex['0']);
            $names['Name'] = ucfirst($ex['1']);
            $names['name'] = strtolower($ex['1']);

        }else{
            $names['dirname'] = 'Default';
            // Article
            $names['Name'] = ucfirst($args_name);
            $names['name'] = strtolower($args_name);
        }

            if (!isset($names[$config])) {
                throw new \Exception("Position name is not found");
            };

            return $names[$config];

    }

    public function getMeta()
    {
        return $this->meta;
    }

    protected function makeVueLayout()
    {
        new MakeVueLayout($this, $this->files);
    }

    protected function makeVueTabs()
    {
        new MakeVueTabs($this, $this->files);
    }

    protected function makeVueEdit()
    {
        new MakeVueEdit($this, $this->files);
    }

    protected function makeVueCreate()
    {
        new MakeVueCreate($this, $this->files);
    }

    protected function makeVueForm()
    {
        new MakeVueForm($this, $this->files);
    }

    protected function makeVueIndex()
    {
        new MakeVueIndex($this, $this->files);
    }
}

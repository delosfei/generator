<?php

namespace Delosfei\Generator\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeBaseCommand extends Command
{
    protected $signature = 'ds:base    
                        {name : The name of the model. (Ex: Post)}
                        {module_name? : The name of the module_name. (Ex: Edu)}';


    protected $description = 'test command';

    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return
            [
                ['name', InputArgument::REQUIRED, 'The name of the model. (Ex: Post)'],
            ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return
            [
                [
                    'schema',
                    's',
                    InputOption::VALUE_REQUIRED,
                    'Schema to generate scaffold files. (Ex: --schema="title:string")',
                    null,
                ],
                [
                    'ui',
                    'ui',
                    InputOption::VALUE_OPTIONAL,
                    'UI Framework to generate scaffold. (default bs4 - bootstrap 4)',
                    'bs4',
                ],
                [
                    'validator',
                    'a',
                    InputOption::VALUE_OPTIONAL,
                    'Validators to generate scaffold files. (Ex: --validator="title:required")',
                    null,
                ],
                [
                    'localization',
                    'l',
                    InputOption::VALUE_OPTIONAL,
                    'Localizations to generate scaffold files. (Ex. --localization="key:value")',
                    null,
                ],
                [
                    'lang',
                    'b',
                    InputOption::VALUE_OPTIONAL,
                    'Language for Localization (Ex. --lang="en")',
                    null,
                ],
                [
                    'form',
                    'f',
                    InputOption::VALUE_OPTIONAL,
                    'use Illumintate/Html Form facade to generate input fields',
                    false,
                ],
                [
                    'prefix',
                    'p',
                    InputOption::VALUE_OPTIONAL,
                    'Generate schema with prefix',
                    false,
                ],
            ];
    }


    public function handle()
    {
        $header = "scaffolding: BaseCode";
        $footer = str_pad('', strlen($header), '-');

        $this->line("\n----------- $header -----------\n");

        $this->info('name'.$this->argument('name')."\n");
        $this->comment('schema---'.$this->option('schema')."\n");
        $this->info('module_name'.$this->argument('module_name')."\n");
        $this->comment('prefix---'.$this->option('prefix'));

        $this->line("\n----------- $footer-----------");
    }


}

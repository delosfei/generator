<?php

namespace Delosfei\Generator\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeBaseCommand extends Command
{
    protected $signature = 'ds:base    
                        {name : The name of the model. (Ex: Post)}
                        {module_name? : The name of the module_name. (Ex: Edu)}
                        {--S|schema= : Schema to generate scaffold files. (Ex: --schema="title:string")}
                        {--U|ui : UI Framework to generate scaffold. (Default Vue ui)}
                        {--A|validator : Validators to generate scaffold files. (Ex: --validator="title:required")}
                        {--L|localization : Localizations to generate scaffold files. (Ex. --localization="key:value")}
                        {--P|prefix : Generate schema with prefix}';


    protected $description = 'test command';

    public function __construct()
    {
        parent::__construct();


    }


    public function handle()
    {
        $header = "scaffolding: BaseCode";
        $footer = str_pad('', strlen($header), '-');

        $this->line("\n----------- $header -----------\n");
        $this->info(dd($this->getOptions('schema'))."\n");
        $this->info('name'.$this->getArguments('name')."\n");
        $this->comment('schema---'.$this->getOptions('schema')."\n");
        $this->info('module_name'.$this->getArguments('module_name')."\n");
        $this->comment('prefix---'.$this->getOptions('prefix'));

        $this->line("\n----------- $footer-----------");
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
                    'UI Framework to generate scaffold. (Default bs4 - bootstrap 4)',
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
                    'Use Illumintate/Html Form facade to generate input fields',
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


}

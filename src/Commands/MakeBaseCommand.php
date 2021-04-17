<?php

namespace Delosfei\Generator\Commands;

use Illuminate\Console\Command;

class MakeBaseCommand extends Command
{
    protected $signature = 'ds:base    
                        {name : The name of the model. (Ex: Post)}
                        {module_name : The name of the module_name. (Ex: Edu)}
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
        $this->info(dd($this->option('schema'))."\n");
        $this->info('name'.$this->argument('name')."\n");
        $this->comment('schema---'.$this->option('schema')."\n");
        $this->info('module_name'.$this->argument('module_name')."\n");
        $this->comment('prefix---'.$this->option('prefix'));

        $this->line("\n----------- $footer-----------");
    }


}

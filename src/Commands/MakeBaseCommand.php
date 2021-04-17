<?php

namespace Delosfei\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class MakeBaseCommand extends Command
{
    protected $signature = 'ds:base
                        {user : The ID of the user}
                        {--queue= : Whether the job should be queued}';
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

        $this->info('test'.$this->argument('user')."\n");
        $this->comment('option'.$this->option('queue'));

        $this->line("\n----------- $footer -----------");
    }


}

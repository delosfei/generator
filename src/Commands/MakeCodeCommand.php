<?php

namespace Delosfei\Generator\Commands;

use Illuminate\Console\Command;


class MakeCodeCommand extends Command
{


    protected $name = 'ds:code';


    protected $description = 'Create a laralib scaffold';


    public function handle()
    {
        $header = "scaffolding: {$this->getObjName("Name")}";
        $footer = str_pad('', strlen($header), '-');
        $dump = str_pad('>DUMP AUTOLOAD<', strlen($header), ' ', STR_PAD_BOTH);

        $this->line("\n----------- $header -----------\n");


        $this->line("\n----------- $footer -----------");
        $this->comment("----------- $dump -----------");



    }


}

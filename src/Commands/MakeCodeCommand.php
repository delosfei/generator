<?php

namespace Delosfei\Generator\Commands;

use Illuminate\Console\Command;

class MakeCodeCommand extends Command
{

    protected $signature = 'ds:code';
//    protected $name = 'ds:code';


    protected $description = 'Command description';



    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        return 1;
    }
}

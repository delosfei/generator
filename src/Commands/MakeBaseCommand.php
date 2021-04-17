<?php

namespace Delosfei\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class MakeBaseCommand extends Command
{
    protected $signature = 'ds:base';
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

        $this->info('以接口方式完成基础配置，实现前端自动路由，组件自动注册，axious请求等');
        $this->line("\n----------- $footer -----------");
    }


}

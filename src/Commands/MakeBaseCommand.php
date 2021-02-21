<?php

namespace Delosfei\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class MakeBaseCommand extends Command
{
   // protected $signature = 'ds:code';
    protected $name = 'ds:base';
    protected $description = '生成基本代码';

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }


    public function handle()
    {
        $header = "scaffolding: BaseCode";
        $footer = str_pad('', strlen($header), '-');

        $this->line("\n----------- $header -----------\n");
        $this->copyFiles();
        $this->info('以接口方式完成基础配置，实现前端自动路由，组件自动注册，axious请求等');
        $this->line("\n----------- $footer -----------");
    }
    protected function path()
    {
        return base_path();
    }
    /**
     * 复制文件
     *
     * @return void
     */
    protected function copyFiles()
    {
        File::copyDirectory(dirname(__DIR__).'/Data/Base', $this->path());
    }


}

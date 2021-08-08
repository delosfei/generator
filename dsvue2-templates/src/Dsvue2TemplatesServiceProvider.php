<?php

namespace Delosfei\Dsvue2Templates;

use Illuminate\Support\ServiceProvider;

class Dsvue2TemplatesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'dsvue2-templates');
        $this->publishes(
            [
                __DIR__.'/../views/vue2' => base_path(),
                __DIR__.'/../views/vue2-user' => base_path(),

            ]
        );
//
//        Paginator::defaultView('dsvue2-templates::common.paginator');
//        Paginator::defaultSimpleView('dsvue2-templates::common.simple_paginator');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}

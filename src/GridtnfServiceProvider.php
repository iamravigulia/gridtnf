<?php

namespace edgewizz\gridtnf;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class GridtnfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Edgewizz\Gridtnf\Controllers\GridtnfController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // dd($this);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__ . '/components', 'gridtnf');
        Blade::component('gridtnf::gridtnf.open', 'gridtnf.open');
        Blade::component('gridtnf::gridtnf.index', 'gridtnf.index');
        Blade::component('gridtnf::gridtnf.edit', 'gridtnf.edit');
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('category', 'App\Helpers\Category');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

}

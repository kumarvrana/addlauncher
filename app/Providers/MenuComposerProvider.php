<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->composeMenu();
        $this->composeTop();
        $this->composeFooter();
        $this->composeAll();
    }

    public function composeMenu()
    {
        view()->composer('partials.menu', 'App\Http\Composers\MenuComposer');
    }

    public function composeTop()
    {
        view()->composer('partials.header', 'App\Http\Composers\MenuComposer');
    }

    public function composeFooter()
    {
        view()->composer('partials.footer', 'App\Http\Composers\MenuComposer');
    }
    public function composeAll()
    {
        view()->composer('*', 'App\Http\Composers\MenuComposer');
    }
}

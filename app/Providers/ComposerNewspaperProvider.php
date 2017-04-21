<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerNewspaperProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
         view()->composer('*', 'App\Http\Composers\NewspapersComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        view()->composer(
            'layouts.aside', 'App\Http\View\Menu'
        );
        view()->composer(
            'layouts.header', 'App\Http\View\Role'
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Untuk Bootstrap 5
        Paginator::useBootstrapFive();
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}

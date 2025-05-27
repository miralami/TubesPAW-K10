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

        // Jika pakai Bootstrap 4, ganti dengan:
        // Paginator::useBootstrap();

        // Kalau Laravel <9 dan belum ada useBootstrapFive(),
        // Anda bisa publish vendor view:
        // php artisan vendor:publish --tag=laravel-pagination
    }
}

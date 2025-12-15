<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gunakan komponen pagination Bootstrap 5 agar ikon tidak raksasa
        Paginator::useBootstrapFive();

        // Set locale tanggal ke Bahasa Indonesia (untuk translatedFormat)
        Carbon::setLocale('id');
    }
}

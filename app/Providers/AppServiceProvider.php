<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Panen;
use App\Models\Penjualan;
use App\Observers\PanenObserver;
use App\Observers\PenjualanObserver;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

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
        Panen::observe(PanenObserver::class);
        // Penjualan::observe(PenjualanObserver::class);
    }
}

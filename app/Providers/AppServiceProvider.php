<?php

namespace App\Providers;

use App\Models\Jadwal;
use Illuminate\Support\ServiceProvider;
use App\Models\Panen;
use App\Models\Penjualan;
use App\Observers\JadwalObserver;
use App\Observers\PanenObserver;
use App\Observers\PenjualanObserver;
use App\Models\Akun;
use App\Observers\AkunObserver;
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
        Penjualan::observe(PenjualanObserver::class);
        Jadwal::observe(JadwalObserver::class);
        Akun::observe(AkunObserver::class);
    }
}

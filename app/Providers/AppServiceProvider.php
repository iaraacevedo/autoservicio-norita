<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- Importante: Importamos la clase URL

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
        // TRUCO PARA RAILWAY:
        // Si la aplicación no está en modo "local" (o sea, está en producción),
        // forzamos a que todos los links y formularios sean HTTPS.
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}

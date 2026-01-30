<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // PENTING: Force HTTPS di production (Railway)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Trust Railway proxy headers
        $this->app['request']->server->set('HTTPS', 'on');
    }
}
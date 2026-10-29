<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Behind Render / load balancers
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Locale is applied in middleware — never touch Session here
        // (session is not started during provider boot)
    }
}

<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());
        Paginator::defaultView('components.pagination');

        // Never serve plain HTTP in production.
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        // Hotel, cruise-terminal and office Wi-Fi is shared, so the per-network cap is generous;
        // the tight cap is per email address.
        RateLimiter::for('forms', function (Request $request) {
            $email = strtolower(input_string($request->input('email')));
            $limits = [Limit::perMinute(40)->by('ip|'.$request->ip())];
            if ($email !== '') {
                $limits[] = Limit::perMinute(5)->by('email|'.$email.'|'.$request->ip());
            }

            return $limits;
        });
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by(strtolower(input_string($request->input('email'))).'|'.$request->ip()));
    }
}

<?php

namespace Stevebauman\Location;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Stevebauman\Location\Commands\Update;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(
            $config = __DIR__.'/../config/location.php', 'location'
        );

        if ($this->app->runningInConsole()) {
            $this->publishes([$config => config_path('location.php')]);
        }

        $this->commands(Update::class);

        Request::macro('location', function (?string $ip = null) {
            return app(LocationManager::class)->get($ip);
        });
    }

    /**
     * Register bindings in the service container.
     */
    public function register(): void
    {
        $this->app->singleton(LocationManager::class);
    }
}

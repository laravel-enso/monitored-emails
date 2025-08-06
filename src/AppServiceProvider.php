<?php

namespace LaravelEnso\MonitoredEmails;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load();
        $this->publish();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(__DIR__.'/../config/monitored-emails.php', 'monitored-emails');
    }

    private function publish()
    {
        $this->publishes([
            __DIR__ . '/../config' => config_path('laravel-enso'),
        ], 'monitored-emails-config');

        $this->publishes([
            __DIR__.'/../client/src/js' => base_path('client/src/js'),
        ], 'monitored-emails-assets');
    }

    public function register()
    {
        //
    }
}

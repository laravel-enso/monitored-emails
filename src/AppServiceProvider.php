<?php

namespace LaravelEnso\MonitoredEmails;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\MonitoredEmails\Commands\FetchUnreadEmails;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load();
        $this->command();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    private function command(): void
    {
        $this->commands(FetchUnreadEmails::class);

        $this->app->booted(fn () => $this->app->make(Schedule::class)
            ->command('enso:monitored-emails:fetch-unread-emails')->hourly());
    }
}

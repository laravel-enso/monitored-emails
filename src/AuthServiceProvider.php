<?php

namespace LaravelEnso\MonitoredEmails;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected array $policies = [];

    public function boot()
    {
        $this->registerPolicies();
    }
}

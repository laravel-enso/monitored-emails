<?php

namespace LaravelEnso\MonitoredEmails\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;
use LaravelEnso\MonitoredEmails\Services\FetchUnreadEmails as Service;

class FetchUnreadEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public function __construct(private MonitoredEmail $email)
    {
    }

    public function handle(): void
    {
        (new Service($this->email))->handle();
    }
}

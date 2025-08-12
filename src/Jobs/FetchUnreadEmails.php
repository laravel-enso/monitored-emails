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

    public $timeout;
    public $tries;

    public function __construct(private MonitoredEmail $email)
    {
        $this->queue = 'heavy';
        $this->timeout = 180;
        $this->tries = 1;
    }

    public function handle(): void
    {
        (new Service($this->email))->handle();
    }
}

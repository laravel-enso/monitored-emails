<?php

namespace LaravelEnso\MonitoredEmails\Commands;

use Illuminate\Console\Command;
use LaravelEnso\MonitoredEmails\Jobs\FetchUnreadEmails as Job;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;

class FetchUnreadEmails extends Command
{
    protected $signature = 'enso:monitored-emails:fetch-unread-emails';

    protected $description = 'Fetches unread emails form all inboxes';

    public function handle()
    {
        MonitoredEmail::active()
            ->each(fn ($mail) => Job::dispatch($mail));
    }
}

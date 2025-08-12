<?php

namespace LaravelEnso\MonitoredEmails\Http\Controllers\Administration;

use LaravelEnso\MonitoredEmails\Tables\Builders\MonitoredEmail;
use Illuminate\Routing\Controller;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected string $tableClass = MonitoredEmail::class;
}

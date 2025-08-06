<?php

namespace LaravelEnso\MonitoredEmails\Http\Controllers\Administration;

use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;
use Illuminate\Routing\Controller;

class Destroy extends Controller
{
    public function __invoke(MonitoredEmail $monitoredEmail)
    {
        $monitoredEmail->delete();

        return [
            'message' => __('The monitored email was successfully deleted'),
            'redirect' => 'administration.index',
        ];
    }
}

<?php

namespace LaravelEnso\MonitoredEmails\Http\Controllers\Administration;

use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;
use Illuminate\Routing\Controller;
use LaravelEnso\MonitoredEmails\Http\Requests\ValidateMonitoredEmail;

class Update extends Controller
{
    public function __invoke(ValidateMonitoredEmail $request, MonitoredEmail $monitoredEmail)
    {
        $monitoredEmail->update($request->validated());

        return ['message' => __('The monitored email was successfully updated')];
    }
}

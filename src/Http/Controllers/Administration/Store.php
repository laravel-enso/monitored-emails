<?php

namespace LaravelEnso\MonitoredEmails\Http\Controllers\Administration;

use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;
use Illuminate\Routing\Controller;
use LaravelEnso\MonitoredEmails\Http\Requests\ValidateMonitoredEmail;

class Store extends Controller
{
    public function __invoke(ValidateMonitoredEmail $request, MonitoredEmail $monitoredEmail)
    {
        $monitoredEmail->fill($request->validated())->save();

        return [
            'message' => __('The monitored email was successfully created'),
            'redirect' => 'administration.edit',
            'param' => ['monitoredEmail' => $monitoredEmail->id],
        ];
    }
}

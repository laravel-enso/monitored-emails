<?php

namespace LaravelEnso\MonitoredEmails\Http\Controllers\Administration;

use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;
use Illuminate\Routing\Controller;
use LaravelEnso\MonitoredEmails\Forms\Builders\MonitoredEmail as Form;

class Edit extends Controller
{
    public function __invoke(MonitoredEmail $monitoredEmail, Form $form)
    {
        return ['form' => $form->edit($monitoredEmail)];
    }
}

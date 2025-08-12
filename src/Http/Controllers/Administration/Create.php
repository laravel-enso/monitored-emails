<?php

namespace LaravelEnso\MonitoredEmails\Http\Controllers\Administration;

use Illuminate\Routing\Controller;
use LaravelEnso\MonitoredEmails\Forms\Builders\MonitoredEmail;

class Create extends Controller
{
    public function __invoke(MonitoredEmail $form)
    {
        return ['form' => $form->create()];
    }
}

<?php

namespace LaravelEnso\MonitoredEmails\Forms\Builders;

use LaravelEnso\MonitoredEmails\Models\MonitoredEmail as Model;
use LaravelEnso\Forms\Services\Form;

class MonitoredEmail
{
    private const TemplatePath = __DIR__.'/../Templates/monitoredEmail.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = new Form($this->templatePath());
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Model $monitoredEmail)
    {
        return $this->form->edit($monitoredEmail);
    }

    protected function templatePath(): string
    {
        return self::TemplatePath;
    }
}

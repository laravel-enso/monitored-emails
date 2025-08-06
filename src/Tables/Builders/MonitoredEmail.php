<?php

namespace LaravelEnso\MonitoredEmails\Tables\Builders;

use LaravelEnso\MonitoredEmails\Models\MonitoredEmail as Model;
use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Tables\Contracts\Table;

class MonitoredEmail implements Table
{
    private const TemplatePath = __DIR__.'/../Templates/monitoredEmails.json';

    public function query(): Builder
    {
        return Model::selectRaw('
            monitored_emails.id
        ');
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}

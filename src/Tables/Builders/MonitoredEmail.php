<?php

namespace LaravelEnso\MonitoredEmails\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail as Model;
use LaravelEnso\Tables\Contracts\Table;

class MonitoredEmail implements Table
{
    private const TemplatePath = __DIR__.'/../Templates/monitoredEmails.json';

    public function query(): Builder
    {
        return Model::selectRaw('
            monitored_emails.id, monitored_emails.email, monitored_emails.host,
            monitored_emails.folder, monitored_emails.protocol,
            monitored_emails.is_active
        ');
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}

<?php

namespace LaravelEnso\MonitoredEmails\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use LaravelEnso\Tables\Traits\TableCache;

class MonitoredMessage extends Model
{
    use TableCache;

    protected $table = 'monitored_email_messages';

    protected $guarded = [];

    public function mail(): Relation
    {
        return $this->belongsTo(MonitoredEmail::class, 'mail_id');
    }

    public function scopeUnprocessed(Builder $query): Builder
    {
        return $query->whereIsProcessed(false);
    }

    public function casts(): array
    {
        return [
            'received_at' => 'datetime',
            'is_processed' => 'boolean',
            'has_attachments' => 'boolean',
        ];
    }
}

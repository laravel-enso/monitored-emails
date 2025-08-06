<?php

namespace LaravelEnso\MonitoredEmails\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use LaravelEnso\Helpers\Casts\Encrypt;
use LaravelEnso\MonitoredEmails\Enums\Protocol;
use LaravelEnso\Tables\Traits\TableCache;

class MonitoredEmail extends Model
{
    use TableCache;

    protected $guarded = [];

    public function messages(): Relation
    {
        return $this->hasMany(MonitoredMessage::class, 'mail_id');
    }

    public function casts(): array
    {
        return [
            'password' => Encrypt::class,
            'protocol' => Protocol::class,
            'is_active' => 'boolean',
        ];
    }
    //
}

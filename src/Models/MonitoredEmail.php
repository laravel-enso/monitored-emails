<?php

namespace LaravelEnso\MonitoredEmails\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use LaravelEnso\Helpers\Casts\Encrypt;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\MonitoredEmails\Enums\Protocol;
use LaravelEnso\Tables\Traits\TableCache;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;

class MonitoredEmail extends Model
{
    use ActiveState, TableCache;

    protected $guarded = [];

    public function messages(): Relation
    {
        return $this->hasMany(MonitoredMessage::class, 'mail_id');
    }

    public function connect(): Client
    {
        $clientManager = new ClientManager();

        $client = $clientManager->make([
            'host' => $this->host,
            'username' => $this->email,
            'password' => $this->password,
            'port' => $this->port ?: $this->protocol->port(),
        ]);

        return tap($client)->connect();
    }

    protected function casts(): array
    {
        return [
            'password' => Encrypt::class,
            'protocol' => Protocol::class,
            'is_active' => 'boolean',
        ];
    }
}

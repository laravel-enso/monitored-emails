<?php

namespace LaravelEnso\MonitoredEmails\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;
use LaravelEnso\MonitoredEmails\Models\MonitoredMessage;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Message;

class FetchUnreadEmails
{
    private Client $client;

    public function __construct(private MonitoredEmail $email)
    {
    }

    public function handle()
    {
        \Log::info('handlig');
        \Log::info($this->email->email);
        $this->init()
            ->fetch();
    }

    private function init(): self
    {
        $clientManager = new ClientManager();

        $this->client = $clientManager->make([
            'host' => $this->email->host,
            'username' => $this->email->email,
            'password' => $this->email->password,
            // 'port' => $this->email->port ?? $this->email->protocol->port(),
        ]);

        $this->client->connect();

        return $this;
    }

    private function fetch(): self
    {
        $folder = $this->email->folder;

        $folder->query()
            ->unseen()
            ->get()
            ->each(fn ($message) => $this->process($message));

        return $this;
    }

    private function process(Message $message): void
    {
        MonitoredMessage::firstOrCreate(
            [
            'message_id' => $message->getMessageId(),
            ],
            [
                'mail_id' => $this->email->id,
                'sender' => $message->getFrom()[0]->mail,
                'subject' => $message->getSubject(),
                'body' => $message->getTextBody() ?: $message->getHtmlBody(),
                'received_at' => Carbon::parse($message->getDate(), 'UTC')
                    ->setTimezone(Config::get('app.timezone'))
                    ->format('Y-m-d H:i:s'),
                'is_processed' => false,
            ]
        );

        $message->setFlag('Seen');
    }
}

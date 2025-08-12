<?php

namespace LaravelEnso\MonitoredEmails\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;
use LaravelEnso\MonitoredEmails\Models\MonitoredMessage;
use Webklex\PHPIMAP\Message;

class FetchUnreadEmails
{
    public function __construct(private MonitoredEmail $email)
    {
    }

    public function handle()
    {
        $this->email->connect()
            ->getFolder($this->email->folder)
            ->query()
            ->unseen()
            ->get()
            ->each(fn ($message) => $this->process($message));
    }

    private function process(Message $message): void
    {
        MonitoredMessage::firstOrCreate([
            'message_id' => $message->getMessageId(),
        ], [
            'mail_id' => $this->email->id,
            'from' => $message->getFrom()[0]->mail,
            'subject' => $message->getSubject(),
            'body' => $message->getTextBody() ?: $message->getHtmlBody(),
            'received_at' => Carbon::parse($message->getDate(), 'UTC')
                ->setTimezone(Config::get('app.timezone'))
                ->format('Y-m-d H:i:s'),
            'has_attachments' => false, //TODO
            'is_processed' => false,
        ]);

        $message->setFlag('Seen');
    }
}

<?php

namespace LaravelEnso\MonitoredEmails\Http\Controllers\Administration;

use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use LaravelEnso\Helpers\Exceptions\EnsoException;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;

class TestEmail extends Controller
{
    public function __invoke(MonitoredEmail $monitoredEmail)
    {
        try {
            $client = $monitoredEmail->connect();
            if (! $client->getFolder($monitoredEmail->folder)) {
                throw new EnsoException('Folder not found');
            }
            $client->disconnect();

            return [
                'status' => true,
                'message' => __('Server connection accepted.'),
            ];
        } catch(\Exception $e) {
            $message = Str::of($e->getMessage())->afterLast(']')->title()->toString();

            return [
                'status' => false,
                'message' => __($message),
            ];
        }
    }
}

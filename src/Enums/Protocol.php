<?php

namespace LaravelEnso\MonitoredEmails\Enums;

use LaravelEnso\Enums\Contracts\Select;
use LaravelEnso\Enums\Traits\Select as Options;

enum Protocol: int implements Select
{
    use Options;

    case IMAP = 1;
    case SecureIMAP = 2;
    case POP3 = 3;
    case SMTP = 4;

    public function port(): int
    {
        return match ($this) {
            self::IMAP => 143,
            self::SecureIMAP => 993,
            self::POP3 => 110,
            self::SMTP => 25,
        };
    }
}

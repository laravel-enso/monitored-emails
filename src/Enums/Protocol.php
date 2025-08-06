<?php

namespace LaravelEnso\MonitoredEmails\Enums;

use LaravelEnso\Enums\Contracts\Select;
use LaravelEnso\Enums\Traits\Select as Options;

enum Protocol: int implements Select
{
    use Options;

    case IMAP = 143;
    case POP3 = 110;
    case SMTP = 25;
}

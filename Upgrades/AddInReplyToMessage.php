<?php

namespace LaravelEnso\Ticketing\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Helpers\Table;

class AddInReplyToMessage implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasColumn('monitored_email_messages', 'in_reply_to');
    }

    public function migrateTable(): void
    {
        Schema::table('monitored_email_messages', function (Blueprint $table) {
            $table->string('in_reply_to')->nullable()->after('message_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monitored_emails_messages', function (Blueprint $table) {
            $table->id();

            $table->string('sender');
            $table->string('subject');

            $table->string('message_id');

            $table->text('body');

            $table->foreignIdFor(MonitoredEmail::class, 'mail_id');

            $table->dateTime('received_at');

            $table->boolean('is_processed')->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitored_emails_messages');
    }
};

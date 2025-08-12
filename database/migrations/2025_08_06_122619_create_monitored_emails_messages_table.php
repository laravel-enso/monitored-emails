<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monitored_email_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(MonitoredEmail::class, 'mail_id');

            $table->string('message_id');

            $table->string('from');
            $table->string('subject');
            $table->text('body');

            $table->dateTime('received_at');

            $table->boolean('has_attachments');
            $table->boolean('is_processed')->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitored_emails_messages');
    }
};

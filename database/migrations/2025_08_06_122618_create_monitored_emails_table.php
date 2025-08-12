<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monitored_emails', function (Blueprint $table) {
            $table->id();

            $table->string('email');
            $table->string('password');
            $table->string('folder');
            $table->string('host');
            $table->string('port', 6)->nullable();

            $table->tinyInteger('protocol');

            $table->boolean('is_active')->index();

            $table->unique(['email', 'folder']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitored_emails');
    }
};

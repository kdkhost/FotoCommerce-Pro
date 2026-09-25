<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cron_logs', function (Blueprint $table) {
            $table->id();
            $table->string('command_signature');
            $table->string('description')->nullable();
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->integer('exit_code')->nullable();
            $table->longText('output')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['command_signature', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cron_logs');
    }
};

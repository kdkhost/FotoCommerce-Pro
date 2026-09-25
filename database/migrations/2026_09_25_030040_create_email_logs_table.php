<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('to_email');
            $table->string('to_name')->nullable();
            $table->foreignId('template_id')->nullable()->constrained('email_templates')->onDelete('set null');
            $table->string('subject');
            $table->string('mailer_driver_used')->nullable();
            $table->string('smtp_host_used')->nullable();
            $table->boolean('success');
            $table->text('error_message')->nullable();
            $table->dateTime('sent_at');
            $table->string('job_id')->nullable();
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['to_email']);
            $table->index(['template_id']);
            $table->index(['success']);
            $table->index(['sent_at']);
            $table->index(['order_id']);
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};

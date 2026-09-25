<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_uuid', 64)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->text('referer')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->boolean('do_not_track')->default(false);
            $table->dateTime('first_visited_at');
            $table->dateTime('last_visited_at');
            $table->timestamps();

            $table->index(['session_uuid']);
            $table->index(['user_id']);
            $table->index(['ip_address']);
            $table->index(['first_visited_at']);
            $table->index(['last_visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_sessions');
    }
};

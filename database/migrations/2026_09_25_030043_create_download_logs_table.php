<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('download_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->foreignId('order_item_id')->nullable()->constrained('order_items')->onDelete('set null');
            $table->foreignId('photo_id')->nullable()->constrained('photos')->onDelete('set null');
            $table->string('variant');
            $table->string('filename')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('success')->default(true);
            $table->bigInteger('bytes_sent')->nullable();
            $table->dateTime('downloaded_at');

            $table->index(['user_id']);
            $table->index(['order_id']);
            $table->index(['order_item_id']);
            $table->index(['photo_id']);
            $table->index(['variant']);
            $table->index(['downloaded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('download_logs');
    }
};

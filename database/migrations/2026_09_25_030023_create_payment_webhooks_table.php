<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_webhooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_gateway_id')->constrained('payment_gateways')->onDelete('cascade');
            $table->string('gateway_event_id')->nullable();
            $table->string('idempotency_key', 128)->unique();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->json('payload');
            $table->json('headers')->nullable();
            $table->boolean('signature_valid')->default(false);
            $table->boolean('processed')->default(false);
            $table->boolean('skipped_idempotency')->default(false);
            $table->string('error_message')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();

            $table->index(['idempotency_key']);
            $table->index(['payment_gateway_id']);
            $table->index(['payment_id']);
            $table->index(['order_id']);
            $table->index(['processed']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_webhooks');
    }
};

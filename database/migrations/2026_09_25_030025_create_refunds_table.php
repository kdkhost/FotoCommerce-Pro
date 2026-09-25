<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');
            $table->string('gateway_refund_id')->nullable();
            $table->string('type');
            $table->text('reason')->nullable();
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->string('status')->default('requested');
            $table->decimal('requested_amount', 12, 2);
            $table->decimal('approved_amount', 12, 2)->default(0);
            $table->string('idempotency_key', 128)->unique();
            $table->dateTime('requested_at');
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->foreignId('created_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['order_id']);
            $table->index(['user_id']);
            $table->index(['payment_id']);
            $table->index(['status']);
            $table->index(['idempotency_key']);
            $table->index(['requested_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};

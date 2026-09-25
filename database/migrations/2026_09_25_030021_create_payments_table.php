<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained('orders')->onDelete('cascade');
            $table->foreignId('gateway_id')->constrained('payment_gateways')->onDelete('cascade');
            $table->string('gateway_payment_id')->nullable()->unique();
            $table->string('gateway_reference')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency')->default('BRL');
            $table->string('status')->default('pending');
            $table->string('method');
            $table->integer('installments')->default(1);
            $table->longText('pix_qr_code_base64')->nullable();
            $table->text('pix_copy_paste')->nullable();
            $table->dateTime('pix_expires_at')->nullable();
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('refunded_amount', 12, 2)->default(0);
            $table->decimal('fee_amount', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->default(0);
            $table->json('transaction_data')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('failed_at')->nullable();
            $table->string('failure_reason')->nullable();
            $table->timestamps();

            $table->index(['gateway_payment_id']);
            $table->index(['status']);
            $table->index(['order_id']);
            $table->index(['gateway_id']);
            $table->index(['method']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

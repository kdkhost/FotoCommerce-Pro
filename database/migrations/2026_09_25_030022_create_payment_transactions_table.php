<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
            $table->string('type');
            $table->string('gateway_transaction_id')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('status');
            $table->json('response_json')->nullable();
            $table->string('error_message')->nullable();
            $table->timestamps();

            $table->index(['payment_id']);
            $table->index(['type']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};

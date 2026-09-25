<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->string('environment')->default('sandbox');
            $table->json('credentials')->nullable();
            $table->json('supported_methods')->nullable();
            $table->decimal('fee_percent', 5, 2)->default(0);
            $table->decimal('fee_fixed', 12, 2)->default(0);
            $table->string('webhook_url')->nullable();
            $table->dateTime('last_tested_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['slug']);
            $table->index(['is_active']);
            $table->index(['environment']);
            $table->index(['sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};

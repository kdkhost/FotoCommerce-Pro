<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('type');
            $table->decimal('value', 12, 2);
            $table->decimal('min_order_value', 12, 2)->default(0);
            $table->decimal('max_discount_value', 12, 2)->nullable();
            $table->integer('uses_limit_per_user')->default(1);
            $table->integer('total_uses_limit')->nullable();
            $table->integer('total_used')->default(0);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['code']);
            $table->index(['is_active']);
            $table->index(['expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

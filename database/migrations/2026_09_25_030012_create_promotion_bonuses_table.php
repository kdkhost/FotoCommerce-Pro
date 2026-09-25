<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->string('type');
            $table->integer('buy_quantity')->default(0);
            $table->integer('get_quantity')->default(0);
            $table->integer('min_quantity')->default(0);
            $table->decimal('min_value', 12, 2)->default(0);
            $table->foreignId('min_size_id')->nullable()->constrained('photo_sizes')->onDelete('set null');
            $table->foreignId('bonus_size_id')->nullable()->constrained('photo_sizes')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['promotion_id']);
            $table->index(['min_size_id']);
            $table->index(['bonus_size_id']);
            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_bonuses');
    }
};

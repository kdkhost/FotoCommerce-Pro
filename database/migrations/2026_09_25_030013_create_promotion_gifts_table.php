<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->foreignId('photo_id')->constrained('photos')->onDelete('cascade');
            $table->foreignId('photo_price_id')->nullable()->constrained('photo_prices')->onDelete('set null');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['promotion_id', 'photo_id']);
            $table->index(['promotion_id']);
            $table->index(['photo_id']);
            $table->index(['photo_price_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_gifts');
    }
};

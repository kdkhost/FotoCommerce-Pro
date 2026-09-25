<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('photo_id')->constrained('photos')->onDelete('cascade');
            $table->foreignId('photo_price_id')->nullable()->constrained('photo_prices')->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->boolean('is_bonus')->default(false);
            $table->foreignId('bonus_origin_promotion_id')->nullable()->constrained('promotions')->onDelete('set null');
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('final_price', 12, 2);
            $table->string('snapshot_name');
            $table->string('snapshot_size')->nullable();
            $table->timestamps();

            $table->index(['cart_id']);
            $table->index(['photo_id']);
            $table->index(['photo_price_id']);
            $table->index(['is_bonus']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};

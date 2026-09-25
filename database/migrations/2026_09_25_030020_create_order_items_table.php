<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('photo_id')->nullable()->constrained('photos')->onDelete('set null');
            $table->foreignId('photo_price_id')->nullable()->constrained('photo_prices')->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->boolean('is_bonus')->default(false);
            $table->string('snapshot_product_name');
            $table->string('snapshot_size_name')->nullable();
            $table->string('snapshot_quality_name')->nullable();
            $table->decimal('snapshot_unit_price', 12, 2);
            $table->decimal('snapshot_discount_amount', 12, 2)->default(0);
            $table->unsignedBigInteger('snapshot_promotion_id')->nullable();
            $table->decimal('snapshot_bonus_amount', 12, 2)->default(0);
            $table->decimal('snapshot_tax_amount', 12, 2)->default(0);
            $table->decimal('snapshot_final_total', 12, 2);
            $table->integer('download_count')->default(0);
            $table->dateTime('last_downloaded_at')->nullable();
            $table->timestamps();

            $table->index(['order_id']);
            $table->index(['photo_id']);
            $table->index(['photo_price_id']);
            $table->index(['is_bonus']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

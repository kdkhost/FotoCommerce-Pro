<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refund_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refund_id')->constrained('refunds')->onDelete('cascade');
            $table->foreignId('order_item_id')->nullable()->constrained('order_items')->onDelete('set null');
            $table->foreignId('photo_id')->nullable()->constrained('photos')->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->decimal('amount', 12, 2);
            $table->string('snapshot_item_name');
            $table->timestamps();

            $table->index(['refund_id']);
            $table->index(['order_item_id']);
            $table->index(['photo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refund_items');
    }
};

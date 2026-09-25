<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->foreignId('photo_id')->nullable()->constrained('photos')->onDelete('set null');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');
            $table->foreignId('order_item_id')->nullable()->constrained('order_items')->onDelete('set null');
            $table->string('type')->default('other');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('open');
            $table->text('admin_notes')->nullable();
            $table->dateTime('filed_at');
            $table->dateTime('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['order_id']);
            $table->index(['photo_id']);
            $table->index(['payment_id']);
            $table->index(['order_item_id']);
            $table->index(['type']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};

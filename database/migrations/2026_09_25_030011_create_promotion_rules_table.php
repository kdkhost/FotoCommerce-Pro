<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->nullable()->constrained('promotions')->onDelete('cascade');
            $table->string('scope');
            $table->foreignId('album_id')->nullable()->constrained('albums')->onDelete('set null');
            $table->string('type');
            $table->json('tiers_json')->nullable();
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_fixed', 12, 2)->default(0);
            $table->integer('priority')->default(0);
            $table->boolean('allow_stack')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['promotion_id']);
            $table->index(['album_id']);
            $table->index(['scope']);
            $table->index(['type']);
            $table->index(['priority']);
            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_rules');
    }
};

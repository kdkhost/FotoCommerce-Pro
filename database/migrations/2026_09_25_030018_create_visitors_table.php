<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_session_id')->constrained('visitor_sessions')->onDelete('cascade');
            $table->string('page_type');
            $table->unsignedBigInteger('page_id')->nullable();
            $table->string('page_path');
            $table->foreignId('album_id')->nullable()->constrained('albums')->onDelete('set null');
            $table->foreignId('photo_id')->nullable()->constrained('photos')->onDelete('set null');
            $table->text('referer')->nullable();
            $table->boolean('is_cart_addition')->default(false);
            $table->boolean('is_checkout_init')->default(false);
            $table->boolean('is_purchase')->default(false);
            $table->dateTime('viewed_at');

            $table->index(['visitor_session_id', 'viewed_at']);
            $table->index(['page_type']);
            $table->index(['album_id']);
            $table->index(['photo_id']);
            $table->index(['viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};

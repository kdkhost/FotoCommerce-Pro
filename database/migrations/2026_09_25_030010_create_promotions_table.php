<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->longText('body_html')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('album_id')->nullable()->constrained('albums')->onDelete('set null');
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('position')->nullable();
            $table->boolean('desktop_only')->default(false);
            $table->boolean('mobile_only')->default(false);
            $table->integer('popup_delay_seconds')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['album_id']);
            $table->index(['type']);
            $table->index(['is_active']);
            $table->index(['sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('event_name')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('event_date')->nullable();
            $table->string('event_location')->nullable();
            $table->string('status')->default('draft');
            $table->string('visibility')->default('public');
            $table->string('password')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('album_categories')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('sort_order')->default(0);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();

            $table->index(['category_id']);
            $table->index(['user_id']);
            $table->index(['status']);
            $table->index(['visibility']);
            $table->index(['event_date']);
            $table->index(['sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};

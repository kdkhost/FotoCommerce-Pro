<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained('albums')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('code')->nullable()->unique();
            $table->longText('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('album_categories')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('original_filename');
            $table->integer('sort_order')->default(0);
            $table->string('status')->default('published');
            $table->boolean('is_featured')->default(false);
            $table->foreignId('photo_size_default_id')->nullable()->constrained('photo_sizes')->onDelete('set null');
            $table->json('metadata')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();

            $table->index(['album_id']);
            $table->index(['category_id']);
            $table->index(['user_id']);
            $table->index(['photo_size_default_id']);
            $table->index(['status']);
            $table->index(['is_featured']);
            $table->index(['sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};

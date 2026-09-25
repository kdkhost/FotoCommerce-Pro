<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained('photos')->onDelete('cascade');
            $table->string('variant');
            $table->string('disk')->default('photos_public');
            $table->string('path');
            $table->string('mime_type')->nullable();
            $table->bigInteger('size_bytes')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('hash_md5')->nullable()->unique();
            $table->timestamps();

            $table->index(['photo_id', 'variant']);
            $table->index(['variant']);
            $table->index(['disk']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_files');
    }
};

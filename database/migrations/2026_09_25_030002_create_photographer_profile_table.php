<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photographer_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('signature_image')->nullable();
            $table->string('site_title');
            $table->string('site_subtitle');
            $table->text('about_text');
            $table->json('social_links')->nullable();
            $table->string('whatsapp_number');
            $table->string('contact_email');
            $table->string('address')->nullable();
            $table->string('pix_key')->nullable();
            $table->timestamps();

            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photographer_profile');
    }
};

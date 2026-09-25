<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('image_desktop_path')->nullable();
            $table->string('image_mobile_path')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_target')->default('_self');
            $table->longText('body_html')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('position')->nullable();
            $table->boolean('desktop_only')->default(false);
            $table->boolean('mobile_only')->default(false);
            $table->timestamps();

            $table->index(['is_active']);
            $table->index(['sort_order']);
            $table->index(['position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_banners');
    }
};

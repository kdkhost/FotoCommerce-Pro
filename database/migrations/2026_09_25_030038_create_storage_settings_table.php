<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('storage_settings', function (Blueprint $table) {
            $table->tinyInteger('single_row_lock')->unsigned()->default(1);
            $table->string('driver')->default('local');
            $table->string('google_client_id')->nullable();
            $table->text('google_client_secret_encrypted')->nullable();
            $table->text('google_refresh_token_encrypted')->nullable();
            $table->string('google_folder_id')->nullable();
            $table->string('google_auth_json_path')->nullable();
            $table->dateTime('last_sync_at')->nullable();
            $table->boolean('sync_enabled')->default(false);
            $table->timestamps();

            $table->primary('single_row_lock');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('storage_settings');
    }
};

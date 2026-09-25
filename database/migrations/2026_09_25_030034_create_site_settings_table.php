<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->tinyInteger('single_row_lock')->unsigned()->default(1);
            $table->string('site_name');
            $table->string('site_slogan')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('logo_dark_path')->nullable();
            $table->string('favicon_path')->nullable();

            $table->string('color_primary', 7)->default('#3b82f6');
            $table->string('color_secondary', 7)->default('#64748b');
            $table->string('color_accent', 7)->default('#f59e0b');
            $table->string('color_background', 7)->default('#ffffff');
            $table->string('color_surface', 7)->default('#f8fafc');
            $table->string('color_text', 7)->default('#0f172a');
            $table->string('color_success', 7)->default('#10b981');
            $table->string('color_warning', 7)->default('#f59e0b');
            $table->string('color_danger', 7)->default('#ef4444');

            $table->string('font_family_base')->default('system-ui');
            $table->string('font_family_heading')->default('system-ui');

            $table->string('login_photo_path')->nullable();
            $table->string('login_overlay_color', 7)->default('#0f172a');
            $table->decimal('login_overlay_opacity', 3, 2)->default(0.65);
            $table->string('login_title')->nullable();
            $table->text('login_description')->nullable();

            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->nullable();
            $table->string('smtp_username')->nullable();
            $table->text('smtp_password_encrypted')->nullable();
            $table->string('smtp_encryption')->nullable();
            $table->string('smtp_from_address')->nullable();
            $table->string('smtp_from_name')->nullable();
            $table->string('smtp_reply_to')->nullable();
            $table->integer('smtp_timeout')->default(30);

            $table->string('fee_pass_type')->default('none');
            $table->decimal('fee_pass_percent', 5, 2)->default(0);
            $table->decimal('fee_pass_fixed', 12, 2)->default(0);

            $table->boolean('progressive_discount_active')->default(true);
            $table->boolean('bonus_system_active')->default(true);

            $table->longText('custom_css')->nullable();
            $table->longText('custom_js')->nullable();

            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();

            $table->boolean('lgpd_consent_active')->default(true);

            $table->timestamps();

            $table->primary('single_row_lock');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

<?php
/**
 * @autor marcelo-brad rj
 * @contato Tel: 21 981325441
 * Email: contato@kdkhost.com.br
 * Telegram: @MARCELO_BRAD
 * Instagram: @marcelobradrj
 * WhatsApp: 21981325441
 */

namespace Database\Seeders;

use App\Models\SeoSetting;
use App\Models\SiteSetting;
use App\Models\StorageSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::create([
            'single_row_lock' => 1,
            'site_name' => 'Fotógrafo Profissional',
            'site_slogan' => 'Registramos os melhores momentos da sua vida',
            'color_primary' => '#3b82f6',
            'color_secondary' => '#64748b',
            'color_accent' => '#f59e0b',
            'color_background' => '#ffffff',
            'color_surface' => '#f8fafc',
            'color_text' => '#0f172a',
            'color_success' => '#10b981',
            'color_warning' => '#f59e0b',
            'color_danger' => '#ef4444',
            'font_family_base' => 'system-ui',
            'font_family_heading' => 'system-ui',
            'login_overlay_color' => '#0f172a',
            'login_overlay_opacity' => 0.65,
            'smtp_timeout' => 30,
            'fee_pass_type' => 'none',
            'fee_pass_percent' => 0,
            'fee_pass_fixed' => 0,
            'progressive_discount_active' => true,
            'bonus_system_active' => true,
            'maintenance_mode' => false,
            'lgpd_consent_active' => true,
        ]);

        SeoSetting::create([
            'robots' => 'index, follow',
            'og_type' => 'website',
            'twitter_card' => 'summary_large_image',
        ]);

        StorageSetting::create([
            'single_row_lock' => 1,
            'driver' => 'local',
            'sync_enabled' => false,
        ]);
    }
}

<?php
/**
 * @autor marcelo-brad rj
 * @contato Tel: 21 981325441
 * Email: contato@kdkhost.com.br
 * Telegram: @MARCELO_BRAD
 * Instagram: @marcelobradrj
 * WhatsApp: 21981325441
 */

namespace App\Models;

use App\Enums\FeePassType;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $primaryKey = 'single_row_lock';

    public $incrementing = false;

    protected $fillable = [
        'single_row_lock',
        'site_name',
        'site_slogan',
        'logo_path',
        'logo_dark_path',
        'favicon_path',
        'color_primary',
        'color_secondary',
        'color_accent',
        'color_background',
        'color_surface',
        'color_text',
        'color_success',
        'color_warning',
        'color_danger',
        'font_family_base',
        'font_family_heading',
        'login_photo_path',
        'login_overlay_color',
        'login_overlay_opacity',
        'login_title',
        'login_description',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password_encrypted',
        'smtp_encryption',
        'smtp_from_address',
        'smtp_from_name',
        'smtp_reply_to',
        'smtp_timeout',
        'fee_pass_type',
        'fee_pass_percent',
        'fee_pass_fixed',
        'progressive_discount_active',
        'bonus_system_active',
        'custom_css',
        'custom_js',
        'maintenance_mode',
        'maintenance_message',
        'lgpd_consent_active',
    ];

    protected function casts(): array
    {
        return [
            'login_overlay_opacity' => 'decimal:2',
            'smtp_port' => 'integer',
            'smtp_timeout' => 'integer',
            'fee_pass_type' => FeePassType::class,
            'fee_pass_percent' => 'decimal:2',
            'fee_pass_fixed' => 'decimal:2',
            'progressive_discount_active' => 'boolean',
            'bonus_system_active' => 'boolean',
            'maintenance_mode' => 'boolean',
            'lgpd_consent_active' => 'boolean',
        ];
    }
}

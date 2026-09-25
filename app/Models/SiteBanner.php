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

use Illuminate\Database\Eloquent\Model;

class SiteBanner extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image_desktop_path',
        'image_mobile_path',
        'link_url',
        'link_target',
        'body_html',
        'starts_at',
        'expires_at',
        'is_active',
        'sort_order',
        'position',
        'desktop_only',
        'mobile_only',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'desktop_only' => 'boolean',
            'mobile_only' => 'boolean',
        ];
    }
}

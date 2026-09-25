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

class SiteSlide extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'image_mobile_path',
        'link_url',
        'link_label',
        'body_html',
        'starts_at',
        'expires_at',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}

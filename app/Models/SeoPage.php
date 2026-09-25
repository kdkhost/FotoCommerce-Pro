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

class SeoPage extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'slug',
        'seo_title',
        'meta_description',
        'keywords_sync',
        'canonical',
        'robots',
        'og_image',
    ];

    protected function casts(): array
    {
        return [
            'keywords_sync' => 'array',
        ];
    }
}

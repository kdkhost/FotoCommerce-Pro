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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotographerProfile extends Model
{
    protected $table = 'photographer_profile';

    protected $fillable = [
        'user_id',
        'bio',
        'cover_image',
        'signature_image',
        'site_title',
        'site_subtitle',
        'about_text',
        'social_links',
        'whatsapp_number',
        'contact_email',
        'address',
        'pix_key',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

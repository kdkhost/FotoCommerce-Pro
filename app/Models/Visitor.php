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

class Visitor extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'visitor_session_id',
        'page_type',
        'page_id',
        'page_path',
        'album_id',
        'photo_id',
        'referer',
        'is_cart_addition',
        'is_checkout_init',
        'is_purchase',
        'viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_cart_addition' => 'boolean',
            'is_checkout_init' => 'boolean',
            'is_purchase' => 'boolean',
            'viewed_at' => 'datetime',
        ];
    }

    public function visitorSession(): BelongsTo
    {
        return $this->belongsTo(VisitorSession::class, 'visitor_session_id');
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }
}

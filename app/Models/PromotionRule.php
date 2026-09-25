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

class PromotionRule extends Model
{
    protected $fillable = [
        'promotion_id',
        'scope',
        'album_id',
        'type',
        'tiers_json',
        'discount_percent',
        'discount_fixed',
        'priority',
        'allow_stack',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tiers_json' => 'array',
            'discount_percent' => 'decimal:2',
            'discount_fixed' => 'decimal:2',
            'priority' => 'integer',
            'allow_stack' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}

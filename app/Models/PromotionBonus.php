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

class PromotionBonus extends Model
{
    protected $fillable = [
        'promotion_id',
        'type',
        'buy_quantity',
        'get_quantity',
        'min_quantity',
        'min_value',
        'min_size_id',
        'bonus_size_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'buy_quantity' => 'integer',
            'get_quantity' => 'integer',
            'min_quantity' => 'integer',
            'min_value' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function minSize(): BelongsTo
    {
        return $this->belongsTo(PhotoSize::class, 'min_size_id');
    }

    public function bonusSize(): BelongsTo
    {
        return $this->belongsTo(PhotoSize::class, 'bonus_size_id');
    }
}

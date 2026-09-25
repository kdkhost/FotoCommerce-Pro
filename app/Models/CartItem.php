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

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'photo_id',
        'photo_price_id',
        'quantity',
        'unit_price',
        'is_bonus',
        'bonus_origin_promotion_id',
        'discount_amount',
        'final_price',
        'snapshot_name',
        'snapshot_size',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'is_bonus' => 'boolean',
            'discount_amount' => 'decimal:2',
            'final_price' => 'decimal:2',
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function photoPrice(): BelongsTo
    {
        return $this->belongsTo(PhotoPrice::class, 'photo_price_id');
    }

    public function bonusPromotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'bonus_origin_promotion_id');
    }
}

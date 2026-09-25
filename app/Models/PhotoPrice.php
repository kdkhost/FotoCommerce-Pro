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
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhotoPrice extends Model
{
    protected $fillable = [
        'photo_id',
        'size_id',
        'price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(PhotoSize::class, 'size_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'photo_price_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'photo_price_id');
    }

    public function promotionGifts(): HasMany
    {
        return $this->hasMany(PromotionGift::class, 'photo_price_id');
    }
}

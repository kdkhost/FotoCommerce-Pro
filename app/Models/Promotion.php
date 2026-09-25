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

use App\Enums\PromotionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    protected $fillable = [
        'type',
        'title',
        'slug',
        'body_html',
        'image',
        'album_id',
        'starts_at',
        'expires_at',
        'is_active',
        'position',
        'desktop_only',
        'mobile_only',
        'popup_delay_seconds',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'type' => PromotionType::class,
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
            'desktop_only' => 'boolean',
            'mobile_only' => 'boolean',
            'popup_delay_seconds' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function rules(): HasMany
    {
        return $this->hasMany(PromotionRule::class, 'promotion_id');
    }

    public function bonuses(): HasMany
    {
        return $this->hasMany(PromotionBonus::class, 'promotion_id');
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(PromotionGift::class, 'promotion_id');
    }

    public function cartItemBonuses(): HasMany
    {
        return $this->hasMany(CartItem::class, 'bonus_origin_promotion_id');
    }
}

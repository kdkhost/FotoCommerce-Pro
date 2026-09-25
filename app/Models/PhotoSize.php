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
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhotoSize extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'width',
        'height',
        'quality',
        'format',
        'description',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'width' => 'integer',
            'height' => 'integer',
            'quality' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function photoPrices(): HasMany
    {
        return $this->hasMany(PhotoPrice::class, 'size_id');
    }

    public function photosWithDefault(): HasMany
    {
        return $this->hasMany(Photo::class, 'photo_size_default_id');
    }

    public function promotionBonusesMinSize(): HasMany
    {
        return $this->hasMany(PromotionBonus::class, 'min_size_id');
    }

    public function promotionBonusesBonusSize(): HasMany
    {
        return $this->hasMany(PromotionBonus::class, 'bonus_size_id');
    }
}

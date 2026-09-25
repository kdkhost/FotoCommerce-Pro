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

class Photo extends Model
{
    protected $fillable = [
        'album_id',
        'title',
        'code',
        'description',
        'category_id',
        'user_id',
        'original_filename',
        'sort_order',
        'status',
        'is_featured',
        'photo_size_default_id',
        'metadata',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_featured' => 'boolean',
            'metadata' => 'array',
        ];
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AlbumCategory::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function defaultSize(): BelongsTo
    {
        return $this->belongsTo(PhotoSize::class, 'photo_size_default_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(PhotoPrice::class, 'photo_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(PhotoFile::class, 'photo_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'photo_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'photo_id');
    }

    public function promotionGifts(): HasMany
    {
        return $this->hasMany(PromotionGift::class, 'photo_id');
    }

    public function refundItems(): HasMany
    {
        return $this->hasMany(RefundItem::class, 'photo_id');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'photo_id');
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class, 'photo_id');
    }

    public function downloadLogs(): HasMany
    {
        return $this->hasMany(DownloadLog::class, 'photo_id');
    }
}

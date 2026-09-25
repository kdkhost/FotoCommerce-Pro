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

use App\Enums\AlbumStatus;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_name',
        'cover_image',
        'event_date',
        'event_location',
        'status',
        'visibility',
        'password',
        'published_at',
        'start_at',
        'end_at',
        'category_id',
        'user_id',
        'sort_order',
        'seo_title',
        'seo_description',
        'og_image',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'published_at' => 'datetime',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'status' => AlbumStatus::class,
            'visibility' => Visibility::class,
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AlbumCategory::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'album_id');
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class, 'album_id');
    }

    public function promotionRules(): HasMany
    {
        return $this->hasMany(PromotionRule::class, 'album_id');
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class, 'album_id');
    }
}

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

class AlbumCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order_column',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'order_column' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AlbumCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(AlbumCategory::class, 'parent_id');
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class, 'category_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'category_id');
    }
}

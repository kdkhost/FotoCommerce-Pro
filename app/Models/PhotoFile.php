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

class PhotoFile extends Model
{
    protected $fillable = [
        'photo_id',
        'variant',
        'disk',
        'path',
        'mime_type',
        'size_bytes',
        'width',
        'height',
        'hash_md5',
    ];

    protected function casts(): array
    {
        return [
            'size_bytes' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
        ];
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }
}

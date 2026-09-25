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

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'photo_id',
        'photo_price_id',
        'quantity',
        'is_bonus',
        'snapshot_product_name',
        'snapshot_size_name',
        'snapshot_quality_name',
        'snapshot_unit_price',
        'snapshot_discount_amount',
        'snapshot_promotion_id',
        'snapshot_bonus_amount',
        'snapshot_tax_amount',
        'snapshot_final_total',
        'download_count',
        'last_downloaded_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'is_bonus' => 'boolean',
            'snapshot_unit_price' => 'decimal:2',
            'snapshot_discount_amount' => 'decimal:2',
            'snapshot_bonus_amount' => 'decimal:2',
            'snapshot_tax_amount' => 'decimal:2',
            'snapshot_final_total' => 'decimal:2',
            'download_count' => 'integer',
            'last_downloaded_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function photoPrice(): BelongsTo
    {
        return $this->belongsTo(PhotoPrice::class, 'photo_price_id');
    }

    public function refundItems(): HasMany
    {
        return $this->hasMany(RefundItem::class, 'order_item_id');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'order_item_id');
    }

    public function downloadLogs(): HasMany
    {
        return $this->hasMany(DownloadLog::class, 'order_item_id');
    }
}

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

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'gateway_id',
        'gateway_payment_id',
        'gateway_reference',
        'amount',
        'currency',
        'status',
        'method',
        'installments',
        'pix_qr_code_base64',
        'pix_copy_paste',
        'pix_expires_at',
        'paid_amount',
        'refunded_amount',
        'fee_amount',
        'net_amount',
        'transaction_data',
        'paid_at',
        'cancelled_at',
        'failed_at',
        'failure_reason',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'status' => PaymentStatus::class,
            'method' => PaymentMethod::class,
            'installments' => 'integer',
            'pix_expires_at' => 'datetime',
            'paid_amount' => 'decimal:2',
            'refunded_amount' => 'decimal:2',
            'fee_amount' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'transaction_data' => 'array',
            'paid_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'failed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class, 'payment_id');
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class, 'payment_id');
    }

    public function paymentWebhooks(): HasMany
    {
        return $this->hasMany(PaymentWebhook::class, 'payment_id');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'payment_id');
    }
}

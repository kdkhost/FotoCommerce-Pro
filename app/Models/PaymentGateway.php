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

class PaymentGateway extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_active',
        'is_default',
        'environment',
        'credentials',
        'supported_methods',
        'fee_percent',
        'fee_fixed',
        'webhook_url',
        'last_tested_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'credentials' => 'array',
            'supported_methods' => 'array',
            'fee_percent' => 'decimal:2',
            'fee_fixed' => 'decimal:2',
            'last_tested_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'gateway_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'payment_gateway_id');
    }

    public function paymentWebhooks(): HasMany
    {
        return $this->hasMany(PaymentWebhook::class, 'payment_gateway_id');
    }
}

<?php
/**
 * @autor marcelo-brad rj
 * @contato Tel: 21 981325441
 * Email: contato@kdkhost.com.br
 * Telegram: @MARCELO_BRAD
 * Instagram: @marcelobradrj
 * WhatsApp: 21981325441
 */

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        PaymentGateway::create([
            'slug' => 'mercadopago',
            'name' => 'Mercado Pago',
            'description' => 'Gateway de pagamento Mercado Pago',
            'is_active' => true,
            'is_default' => true,
            'environment' => 'sandbox',
            'credentials' => null,
            'supported_methods' => ['pix', 'credit_card', 'boleto'],
            'fee_percent' => 0,
            'fee_fixed' => 0,
            'sort_order' => 1,
        ]);
    }
}

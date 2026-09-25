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

use App\Models\PhotoSize;
use Illuminate\Database\Seeder;

class PhotoSizeSeeder extends Seeder
{
    public function run(): void
    {
        PhotoSize::create([
            'name' => 'Standard',
            'slug' => 'standard',
            'width' => 1200,
            'height' => 800,
            'quality' => 80,
            'format' => 'jpg',
            'description' => 'Tamanho padrão para compartilhamento em redes sociais',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        PhotoSize::create([
            'name' => 'HD',
            'slug' => 'hd',
            'width' => 1920,
            'height' => 1280,
            'quality' => 90,
            'format' => 'jpg',
            'description' => 'Alta definição para impressões pequenas',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        PhotoSize::create([
            'name' => 'Full HD',
            'slug' => 'full-hd',
            'width' => 2560,
            'height' => 1707,
            'quality' => 92,
            'format' => 'jpg',
            'description' => 'Full HD para impressões médias',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        PhotoSize::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'width' => 3840,
            'height' => 2560,
            'quality' => 95,
            'format' => 'jpg',
            'description' => 'Qualidade premium para impressões grandes',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        PhotoSize::create([
            'name' => 'Original',
            'slug' => 'original',
            'width' => 0,
            'height' => 0,
            'quality' => 100,
            'format' => 'jpg',
            'description' => 'Arquivo original sem redimensionamento',
            'is_active' => true,
            'sort_order' => 5,
        ]);
    }
}

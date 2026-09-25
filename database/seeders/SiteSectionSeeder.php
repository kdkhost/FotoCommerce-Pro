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

use App\Models\SiteSection;
use Illuminate\Database\Seeder;

class SiteSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['section_key' => 'hero', 'sort_order' => 1, 'title' => 'Destaque Principal'],
            ['section_key' => 'albums', 'sort_order' => 2, 'title' => 'Álbuns em Destaque'],
            ['section_key' => 'promotions', 'sort_order' => 3, 'title' => 'Promoções'],
            ['section_key' => 'featured', 'sort_order' => 4, 'title' => 'Fotos em Destaque'],
            ['section_key' => 'testimonials', 'sort_order' => 5, 'title' => 'Depoimentos'],
            ['section_key' => 'cta', 'sort_order' => 6, 'title' => 'Chamada para Ação'],
            ['section_key' => 'newsletter', 'sort_order' => 7, 'title' => 'Newsletter'],
            ['section_key' => 'footer', 'sort_order' => 8, 'title' => 'Rodapé'],
        ];

        foreach ($sections as $section) {
            SiteSection::create([
                'section_key' => $section['section_key'],
                'is_active' => true,
                'sort_order' => $section['sort_order'],
                'title' => $section['title'],
            ]);
        }
    }
}

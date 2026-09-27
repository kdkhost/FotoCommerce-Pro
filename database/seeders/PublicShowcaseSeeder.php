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

use App\Enums\AlbumStatus;
use App\Enums\UserType;
use App\Enums\Visibility;
use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\PhotographerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        $photographer = User::firstOrCreate(
            ['email' => 'contato@fotografo.com.br'],
            [
                'name' => 'Estúdio Fotográfico',
                'password' => Hash::make(Str::random(32)),
                'type' => UserType::Admin,
                'email_verified_at' => now(),
            ]
        );

        if ($photographer->wasRecentlyCreated && \Spatie\Permission\Models\Role::where('name', 'Super Admin')->exists()) {
            $photographer->assignRole('Super Admin');
        }

        PhotographerProfile::firstOrCreate(
            ['user_id' => $photographer->id],
            [
                'bio' => 'Fotógrafo profissional com mais de 10 anos de experiência em casamentos, ensaios e eventos.',
                'site_title' => 'Estúdio Fotográfico',
                'site_subtitle' => 'Registrando os momentos mais importantes da sua vida',
                'about_text' => 'Somos especializados em capturar emoções genuínas em casamentos, ensaios, aniversários e eventos corporativos. Cada clique é pensado para eternizar histórias únicas com sensibilidade, técnica e um olhar autoral.',
                'social_links' => [
                    'instagram' => 'https://instagram.com/',
                    'facebook' => 'https://facebook.com/',
                ],
                'whatsapp_number' => '5521900000000',
                'contact_email' => 'contato@fotografo.com.br',
                'address' => 'Rio de Janeiro, RJ',
            ]
        );

        $categories = [
            ['name' => 'Casamentos', 'slug' => 'casamentos', 'from' => '#ec4899', 'to' => '#f97316'],
            ['name' => 'Ensaios Fotográficos', 'slug' => 'ensaios', 'from' => '#8b5cf6', 'to' => '#3b82f6'],
            ['name' => 'Aniversários', 'slug' => 'aniversarios', 'from' => '#f59e0b', 'to' => '#ef4444'],
            ['name' => 'Corporativo', 'slug' => 'corporativo', 'from' => '#0ea5e9', 'to' => '#1e293b'],
            ['name' => 'Gestante & Newborn', 'slug' => 'gestante-newborn', 'from' => '#f472b6', 'to' => '#fb7185'],
        ];

        $categoryModels = [];
        foreach ($categories as $index => $category) {
            $categoryModels[$category['slug']] = AlbumCategory::firstOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'is_active' => true,
                    'order_column' => $index,
                ]
            );
        }

        $albums = [
            [
                'title' => 'Ana & João — Casamento no Jardim',
                'slug' => 'ana-e-joao-casamento',
                'category' => 'casamentos',
                'event_name' => 'Casamento Ana & João',
                'event_location' => 'Rio de Janeiro, RJ',
                'description' => 'Uma celebração ao ar livre repleta de emoção, luz natural e detalhes cuidadosamente planejados.',
                'colors' => ['#ec4899', '#f97316'],
            ],
            [
                'title' => 'Ensaio Urbano — Camila',
                'slug' => 'ensaio-urbano-camila',
                'category' => 'ensaios',
                'event_name' => 'Ensaio Fotográfico Urbano',
                'event_location' => 'Centro, Rio de Janeiro',
                'description' => 'Ensaio autoral explorando texturas e arquitetura urbana como cenário.',
                'colors' => ['#8b5cf6', '#3b82f6'],
            ],
            [
                'title' => '15 Anos — Beatriz',
                'slug' => '15-anos-beatriz',
                'category' => 'aniversarios',
                'event_name' => 'Festa de 15 Anos',
                'event_location' => 'Barra da Tijuca, RJ',
                'description' => 'Registro completo da festa de debut, do making of à pista de dança.',
                'colors' => ['#f59e0b', '#ef4444'],
            ],
            [
                'title' => 'Evento Corporativo — Tech Summit',
                'slug' => 'evento-tech-summit',
                'category' => 'corporativo',
                'event_name' => 'Tech Summit 2026',
                'event_location' => 'Barra da Tijuca, RJ',
                'description' => 'Cobertura fotográfica de palestras, networking e premiações do evento.',
                'colors' => ['#0ea5e9', '#1e293b'],
            ],
            [
                'title' => 'Gestante — Mariana',
                'slug' => 'gestante-mariana',
                'category' => 'gestante-newborn',
                'event_name' => 'Ensaio Gestante',
                'event_location' => 'Estúdio',
                'description' => 'Ensaio delicado celebrando a espera do primeiro filho.',
                'colors' => ['#f472b6', '#fb7185'],
            ],
            [
                'title' => 'Newborn — Pedro',
                'slug' => 'newborn-pedro',
                'category' => 'gestante-newborn',
                'event_name' => 'Ensaio Newborn',
                'event_location' => 'Estúdio',
                'description' => 'Primeiros dias de vida registrados com todo cuidado e delicadeza.',
                'colors' => ['#fda4af', '#f472b6'],
            ],
        ];

        foreach ($albums as $index => $data) {
            $album = Album::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'event_name' => $data['event_name'],
                    'event_date' => now()->subDays(($index + 1) * 12),
                    'event_location' => $data['event_location'],
                    'status' => AlbumStatus::Published,
                    'visibility' => Visibility::Public,
                    'published_at' => now()->subDays(($index + 1) * 10),
                    'category_id' => $categoryModels[$data['category']]->id,
                    'user_id' => $photographer->id,
                    'sort_order' => $index,
                ]
            );

            if ($album->wasRecentlyCreated) {
                $path = 'covers/'.$data['slug'].'.jpg';
                $this->generateCoverImage($path, $data['colors'][0], $data['colors'][1]);
                $album->update(['cover_image' => $path]);
            }
        }
    }

    private function generateCoverImage(string $path, string $colorFrom, string $colorTo): void
    {
        $width = 1200;
        $height = 800;

        [$r1, $g1, $b1] = sscanf($colorFrom, '#%02x%02x%02x');
        [$r2, $g2, $b2] = sscanf($colorTo, '#%02x%02x%02x');

        $image = imagecreatetruecolor($width, $height);

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $r = (int) ($r1 + ($r2 - $r1) * $ratio);
            $g = (int) ($g1 + ($g2 - $g1) * $ratio);
            $b = (int) ($b1 + ($b2 - $b1) * $ratio);
            $color = imagecolorallocate($image, $r, $g, $b);
            imageline($image, 0, $y, $width, $y, $color);
        }

        imagealphablending($image, true);
        for ($i = 0; $i < 6; $i++) {
            $cx = random_int(0, $width);
            $cy = random_int(0, $height);
            $radius = random_int(120, 320);
            $circleColor = imagecolorallocatealpha($image, 255, 255, 255, random_int(100, 118));
            imagefilledellipse($image, $cx, $cy, $radius, $radius, $circleColor);
        }

        ob_start();
        imagejpeg($image, null, 85);
        $binary = ob_get_clean();
        imagedestroy($image);

        Storage::disk('photos_public')->put($path, $binary);
    }
}

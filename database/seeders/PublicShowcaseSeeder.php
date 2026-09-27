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
use App\Models\Photo;
use App\Models\PhotoFile;
use App\Models\PhotographerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicShowcaseSeeder extends Seeder
{
    /**
     * Demo photos bundled with the repo (Lorem Picsum, free-use stock images)
     * used only to populate the showcase until real client photos exist.
     */
    private const DEMO_PHOTO_COUNT = 20;

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
            ['name' => 'Casamentos', 'slug' => 'casamentos'],
            ['name' => 'Ensaios Fotográficos', 'slug' => 'ensaios'],
            ['name' => 'Aniversários', 'slug' => 'aniversarios'],
            ['name' => 'Corporativo', 'slug' => 'corporativo'],
            ['name' => 'Gestante & Newborn', 'slug' => 'gestante-newborn'],
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
            ],
            [
                'title' => 'Ensaio Urbano — Camila',
                'slug' => 'ensaio-urbano-camila',
                'category' => 'ensaios',
                'event_name' => 'Ensaio Fotográfico Urbano',
                'event_location' => 'Centro, Rio de Janeiro',
                'description' => 'Ensaio autoral explorando texturas e arquitetura urbana como cenário.',
            ],
            [
                'title' => '15 Anos — Beatriz',
                'slug' => '15-anos-beatriz',
                'category' => 'aniversarios',
                'event_name' => 'Festa de 15 Anos',
                'event_location' => 'Barra da Tijuca, RJ',
                'description' => 'Registro completo da festa de debut, do making of à pista de dança.',
            ],
            [
                'title' => 'Evento Corporativo — Tech Summit',
                'slug' => 'evento-tech-summit',
                'category' => 'corporativo',
                'event_name' => 'Tech Summit 2026',
                'event_location' => 'Barra da Tijuca, RJ',
                'description' => 'Cobertura fotográfica de palestras, networking e premiações do evento.',
            ],
            [
                'title' => 'Gestante — Mariana',
                'slug' => 'gestante-mariana',
                'category' => 'gestante-newborn',
                'event_name' => 'Ensaio Gestante',
                'event_location' => 'Estúdio',
                'description' => 'Ensaio delicado celebrando a espera do primeiro filho.',
            ],
            [
                'title' => 'Newborn — Pedro',
                'slug' => 'newborn-pedro',
                'category' => 'gestante-newborn',
                'event_name' => 'Ensaio Newborn',
                'event_location' => 'Estúdio',
                'description' => 'Primeiros dias de vida registrados com todo cuidado e delicadeza.',
            ],
        ];

        $demoPhotos = $this->demoPhotoFilenames();
        $coverPhotos = array_splice($demoPhotos, 0, count($albums));
        $galleryPhotos = $demoPhotos;
        $galleryIndex = 0;

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

            if (! $album->wasRecentlyCreated) {
                continue;
            }

            $coverPath = 'covers/'.$data['slug'].'.jpg';
            $this->copyDemoPhoto($coverPhotos[$index], $coverPath);
            $album->update(['cover_image' => $coverPath]);

            $photosForAlbum = ($index < 2) ? 3 : 2;
            for ($p = 0; $p < $photosForAlbum && $galleryIndex < count($galleryPhotos); $p++) {
                $galleryPath = 'gallery/'.$data['slug'].'/'.($p + 1).'.jpg';
                $dimensions = $this->copyDemoPhoto($galleryPhotos[$galleryIndex], $galleryPath);
                $galleryIndex++;

                $photo = Photo::create([
                    'album_id' => $album->id,
                    'title' => $data['event_name'].' #'.($p + 1),
                    'category_id' => $categoryModels[$data['category']]->id,
                    'user_id' => $photographer->id,
                    'original_filename' => basename($galleryPath),
                    'sort_order' => $p,
                    'status' => 'published',
                    'is_featured' => $p === 0,
                ]);

                PhotoFile::create([
                    'photo_id' => $photo->id,
                    'variant' => 'gallery',
                    'disk' => 'photos_public',
                    'path' => $galleryPath,
                    'mime_type' => 'image/jpeg',
                    'size_bytes' => $dimensions['size'],
                    'width' => $dimensions['width'],
                    'height' => $dimensions['height'],
                ]);
            }
        }
    }

    /**
     * @return array<int, string>
     */
    private function demoPhotoFilenames(): array
    {
        $filenames = [];

        for ($i = 1; $i <= self::DEMO_PHOTO_COUNT; $i++) {
            $filenames[] = sprintf('photo-%02d.jpg', $i);
        }

        return $filenames;
    }

    /**
     * @return array{width: int, height: int, size: int}
     */
    private function copyDemoPhoto(string $filename, string $targetPath): array
    {
        $sourcePath = database_path('seeders/assets/demo-photos/'.$filename);
        $binary = file_get_contents($sourcePath);

        Storage::disk('photos_public')->put($targetPath, $binary);

        [$width, $height] = getimagesize($sourcePath);

        return [
            'width' => $width,
            'height' => $height,
            'size' => strlen($binary),
        ];
    }
}

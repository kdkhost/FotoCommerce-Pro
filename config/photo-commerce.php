<?php

/**
 * @autor marcelo-brad rj
 * @contato Tel: 21 981325441
 * Email: contato@kdkhost.com.br
 * Telegram: @MARCELO_BRAD
 * Instagram: @marcelobradrj
 * WhatsApp: 21981325441
 */

return [

    'name' => env('APP_NAME', 'Photo Commerce'),

    'admin_prefix' => env('ADMIN_PREFIX', 'admin'),

    'storage' => [
        'driver' => env('PHOTO_STORAGE_DRIVER', 'local'),
    ],

    'upload' => [
        'max_image_mb' => (int) env('UPLOAD_MAX_IMAGE_MB', 16),
    ],

    'image' => [
        'jpeg_quality' => (int) env('IMAGE_JPEG_QUALITY', 85),
        'webp_quality' => (int) env('IMAGE_WEBP_QUALITY', 80),

        'dimensions' => [
            'banner_desktop' => [
                'width'  => 1920,
                'height' => 650,
                'label'  => 'Banner Desktop',
            ],
            'banner_mobile' => [
                'width'  => 768,
                'height' => 900,
                'label'  => 'Banner Mobile',
            ],
            'cover' => [
                'width'  => 1200,
                'height' => 800,
                'label'  => 'Capa de Álbum',
            ],
            'opengraph' => [
                'width'  => 1200,
                'height' => 630,
                'label'  => 'Open Graph / Compartilhamento',
            ],
            'avatar' => [
                'width'  => 400,
                'height' => 400,
                'label'  => 'Avatar',
            ],
        ],
    ],

    'queue' => [
        'connection' => env('QUEUE_CONNECTION', 'database'),
    ],

    'analytics' => [
        'enabled'     => (bool) env('ANALYTICS_ENABLED', true),
        'anonymize_ip'=> (bool) env('ANALYTICS_ANONYMIZE_IP', true),
        'respect_dnt' => (bool) env('ANALYTICS_RESPECT_DNT', true),
    ],

];

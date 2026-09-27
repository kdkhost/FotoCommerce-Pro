<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->site_name ?? config('app.name', 'Photo Commerce') }}</title>
    <meta name="description" content="{{ $settings->site_slogan ?? 'Fotografia profissional' }}">

    <style>
        :root {
            --color-primary: {{ $settings->color_primary ?? '#3b82f6' }};
            --color-secondary: {{ $settings->color_secondary ?? '#64748b' }};
            --color-accent: {{ $settings->color_accent ?? '#f59e0b' }};
            --color-background: {{ $settings->color_background ?? '#ffffff' }};
            --color-surface: {{ $settings->color_surface ?? '#f8fafc' }};
            --color-text: {{ $settings->color_text ?? '#0f172a' }};
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: {{ $settings->font_family_base ?? 'system-ui' }}, sans-serif;
            background: var(--color-background);
            color: var(--color-text);
            line-height: 1.6;
        }

        h1, h2, h3 {
            font-family: {{ $settings->font_family_heading ?? 'system-ui' }}, sans-serif;
        }

        a { color: var(--color-primary); }

        header.hero {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            color: #fff;
            padding: 5rem 1.5rem;
            text-align: center;
        }

        header.hero h1 { font-size: 2.5rem; margin: 0 0 .5rem; }
        header.hero p { font-size: 1.15rem; opacity: .9; margin: 0; }

        main { max-width: 1100px; margin: 0 auto; padding: 3rem 1.5rem; }

        section { margin-bottom: 3.5rem; }

        section h2 {
            font-size: 1.6rem;
            border-left: 4px solid var(--color-accent);
            padding-left: .75rem;
            margin-bottom: 1.25rem;
        }

        .card {
            background: var(--color-surface);
            border-radius: .5rem;
            padding: 1.5rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.25rem;
        }

        .album-card img {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: .5rem .5rem 0 0;
        }

        .album-card {
            background: var(--color-surface);
            border-radius: .5rem;
            overflow: hidden;
        }

        .album-card .body { padding: 1rem; }
        .album-card h3 { margin: 0 0 .25rem; font-size: 1.05rem; }
        .album-card small { color: var(--color-secondary); }

        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--color-secondary);
        }

        .chips { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1.5rem; }
        .chip {
            background: var(--color-surface);
            border: 1px solid var(--color-secondary);
            border-radius: 999px;
            padding: .25rem .9rem;
            font-size: .85rem;
        }

        footer {
            text-align: center;
            padding: 2rem 1.5rem;
            color: var(--color-secondary);
            border-top: 1px solid var(--color-surface);
        }

        .whatsapp-button {
            display: inline-block;
            background: var(--color-accent);
            color: #fff;
            padding: .75rem 1.5rem;
            border-radius: .5rem;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <header class="hero">
        <h1>{{ $settings->site_name ?? config('app.name', 'Photo Commerce') }}</h1>
        @if (!empty($settings?->site_slogan))
            <p>{{ $settings->site_slogan }}</p>
        @endif
    </header>

    <main>
        @if ($profile)
            <section>
                <h2>Sobre</h2>
                <div class="card">
                    @if (!empty($profile->about_text))
                        <p>{{ $profile->about_text }}</p>
                    @elseif (!empty($profile->bio))
                        <p>{{ $profile->bio }}</p>
                    @endif
                </div>
            </section>
        @endif

        <section>
            <h2>Álbuns</h2>

            @if ($categories->isNotEmpty())
                <div class="chips">
                    @foreach ($categories as $category)
                        <span class="chip">{{ $category->name }}</span>
                    @endforeach
                </div>
            @endif

            @if ($albums->isNotEmpty())
                <div class="grid">
                    @foreach ($albums as $album)
                        <div class="album-card">
                            @if ($album->cover_image)
                                <img src="{{ Illuminate\Support\Facades\Storage::disk('photos_public')->url($album->cover_image) }}" alt="{{ $album->title }}">
                            @endif
                            <div class="body">
                                <h3>{{ $album->title }}</h3>
                                @if ($album->category)
                                    <small>{{ $album->category->name }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state card">
                    <p>Novos álbuns em breve. Volte para conferir as próximas sessões fotográficas.</p>
                </div>
            @endif
        </section>

        <section>
            <h2>Contato</h2>
            <div class="card">
                @if ($profile?->whatsapp_number)
                    <p>
                        <a class="whatsapp-button" href="https://wa.me/{{ preg_replace('/\D/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener">
                            Falar no WhatsApp
                        </a>
                    </p>
                @endif

                @if ($profile?->contact_email)
                    <p>E-mail: <a href="mailto:{{ $profile->contact_email }}">{{ $profile->contact_email }}</a></p>
                @endif

                @if (!$profile?->whatsapp_number && !$profile?->contact_email)
                    <p>Canais de contato serão publicados em breve.</p>
                @endif
            </div>
        </section>
    </main>

    <footer>
        &copy; {{ now()->year }} {{ $settings->site_name ?? config('app.name', 'Photo Commerce') }}
    </footer>

</body>
</html>

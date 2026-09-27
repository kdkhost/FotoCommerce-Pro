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
            --font-base: {{ $settings->font_family_base ?? 'system-ui' }}, sans-serif;
            --font-heading: {{ $settings->font_family_heading ?? 'system-ui' }}, sans-serif;
            --shadow-soft: 0 10px 30px -12px rgba(15, 23, 42, .18);
            --shadow-strong: 0 24px 48px -18px rgba(15, 23, 42, .32);
            --radius-lg: 1rem;
            --header-height: 4.25rem;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            font-family: var(--font-base);
            background: var(--color-background);
            color: var(--color-text);
            line-height: 1.65;
        }

        h1, h2, h3 { font-family: var(--font-heading); margin: 0; }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        svg { flex-shrink: 0; }

        .container { max-width: 1180px; margin: 0 auto; padding: 0 1.5rem; }

        /* ---------- Header ---------- */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 40;
            height: var(--header-height);
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: saturate(180%) blur(10px);
            border-bottom: 1px solid rgba(15, 23, 42, .06);
        }

        .site-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .brand { font-weight: 700; font-size: 1.25rem; color: var(--color-text); }

        .desktop-nav { display: none; align-items: center; gap: 1.75rem; }
        .desktop-nav a {
            font-weight: 500;
            font-size: .93rem;
            color: var(--color-text);
            opacity: .8;
            transition: opacity .2s ease, color .2s ease;
        }
        .desktop-nav a:hover { opacity: 1; color: var(--color-primary); }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .7rem 1.5rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: .9rem;
            border: none;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
            white-space: nowrap;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-soft); }
        .btn-primary { background: var(--color-primary); color: #fff; }
        .btn-accent { background: var(--color-accent); color: #fff; }
        .btn-outline { background: transparent; border: 1.5px solid currentColor; }

        /* ---------- Mobile menu toggle ---------- */
        .menu-toggle {
            display: inline-flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 44px;
            height: 44px;
            border: none;
            background: transparent;
            border-radius: .5rem;
            cursor: pointer;
        }
        .menu-toggle span {
            width: 22px;
            height: 2px;
            background: var(--color-text);
            border-radius: 2px;
            transition: transform .25s ease, opacity .25s ease;
        }
        .menu-toggle[aria-expanded="true"] span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .menu-toggle[aria-expanded="true"] span:nth-child(2) { opacity: 0; }
        .menu-toggle[aria-expanded="true"] span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ---------- Mobile slide-in drawer ---------- */
        .drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .55);
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transition: opacity .3s ease, visibility .3s ease;
        }
        .drawer-overlay.is-open { opacity: 1; visibility: visible; }

        .drawer {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: min(80vw, 320px);
            background: #fff;
            z-index: 60;
            box-shadow: var(--shadow-soft);
            transform: translateX(-100%);
            transition: transform .35s cubic-bezier(.22, 1, .36, 1);
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            overflow-y: auto;
        }
        .drawer.is-open { transform: translateX(0); }

        .drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .drawer-close {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--color-surface);
            border-radius: 999px;
            font-size: 1.1rem;
            cursor: pointer;
        }

        .drawer-nav { display: flex; flex-direction: column; gap: 1.4rem; }
        .drawer-nav a {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--color-text);
        }

        .drawer-footer { margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--color-surface); }

        body.drawer-locked { overflow: hidden; }

        @media (min-width: 900px) {
            .desktop-nav { display: flex; }
            .menu-toggle { display: none; }
        }

        /* ---------- Hero ---------- */
        .hero {
            position: relative;
            color: #fff;
            padding: 7rem 0 7.5rem;
            text-align: center;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        }
        .hero .eyebrow {
            display: inline-block;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, .18);
            padding: .4rem 1rem;
            border-radius: 999px;
            margin-bottom: 1.25rem;
        }
        .hero h1 { font-size: clamp(2.1rem, 5vw, 3.5rem); margin-bottom: 1rem; }
        .hero p { font-size: clamp(1rem, 2vw, 1.25rem); opacity: .94; max-width: 640px; margin: 0 auto 2.25rem; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; }
        .hero-actions .btn-light { background: #fff; color: var(--color-text); }
        .hero-actions .btn-outline { border-color: rgba(255, 255, 255, .7); color: #fff; }

        /* ---------- Sections ---------- */
        section { padding: 5rem 0; }
        section.alt { background: var(--color-surface); }

        .section-title { font-size: clamp(1.6rem, 3vw, 2.15rem); margin-bottom: .75rem; text-align: center; }
        .section-subtitle {
            text-align: center;
            color: var(--color-secondary);
            max-width: 640px;
            margin: 0 auto 3rem;
        }

        /* ---------- Services ---------- */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 1.5rem;
        }
        .service-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2rem 1.75rem;
            box-shadow: var(--shadow-soft);
            transition: transform .3s ease, box-shadow .3s ease;
            display: flex;
            flex-direction: column;
            gap: .9rem;
        }
        .service-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-strong); }
        .service-icon {
            width: 54px;
            height: 54px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--color-primary) 12%, transparent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-primary);
        }
        .service-card h3 { font-size: 1.1rem; }
        .service-card p { color: var(--color-secondary); font-size: .92rem; margin: 0; flex: 1; }
        .service-card .service-link { font-weight: 600; font-size: .88rem; color: var(--color-primary); }

        /* ---------- Portfolio masonry ---------- */
        .portfolio-grid {
            column-count: 1;
            column-gap: 1.25rem;
        }
        @media (min-width: 640px) { .portfolio-grid { column-count: 2; } }
        @media (min-width: 980px) { .portfolio-grid { column-count: 3; } }

        .portfolio-item {
            break-inside: avoid;
            margin-bottom: 1.25rem;
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
            box-shadow: var(--shadow-soft);
        }
        .portfolio-item img {
            width: 100%;
            transition: transform .5s ease;
        }
        .portfolio-item:hover img { transform: scale(1.06); }
        .portfolio-item .caption {
            position: absolute;
            inset: auto 0 0 0;
            padding: 1rem;
            background: linear-gradient(0deg, rgba(15,23,42,.75), transparent);
            color: #fff;
            font-size: .85rem;
            opacity: 0;
            transition: opacity .3s ease;
        }
        .portfolio-item:hover .caption { opacity: 1; }

        /* ---------- Process ---------- */
        .process-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.75rem;
            counter-reset: step;
        }
        .process-step { text-align: center; }
        .process-step .step-number {
            width: 46px;
            height: 46px;
            margin: 0 auto .9rem;
            border-radius: 999px;
            background: var(--color-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .process-step h3 { font-size: 1rem; margin-bottom: .4rem; }
        .process-step p { color: var(--color-secondary); font-size: .88rem; margin: 0; }

        /* ---------- About ---------- */
        .about-content {
            display: grid;
            gap: 2rem;
            align-items: center;
        }
        @media (min-width: 860px) {
            .about-content { grid-template-columns: 1fr 1fr; }
        }
        .about-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-soft);
        }

        .chips { display: flex; flex-wrap: wrap; gap: .6rem; justify-content: center; margin-bottom: 2.5rem; }
        .chip {
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 999px;
            padding: .4rem 1.1rem;
            font-size: .85rem;
            font-weight: 500;
            color: var(--color-secondary);
        }

        /* ---------- Albums ---------- */
        .albums-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 1.75rem;
        }

        .album-card {
            background: #fff;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .album-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-strong); }

        .album-card .thumb {
            position: relative;
            aspect-ratio: 4 / 3;
            overflow: hidden;
        }
        .album-card .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }
        .album-card:hover .thumb img { transform: scale(1.08); }

        .album-card .badge {
            position: absolute;
            top: .75rem;
            left: .75rem;
            background: rgba(255, 255, 255, .92);
            color: var(--color-text);
            font-size: .72rem;
            font-weight: 600;
            padding: .3rem .7rem;
            border-radius: 999px;
        }

        .album-card .body { padding: 1.25rem; }
        .album-card h3 { font-size: 1.05rem; margin-bottom: .35rem; }
        .album-card .meta { color: var(--color-secondary); font-size: .85rem; }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            background: #fff;
            border-radius: var(--radius-lg);
            color: var(--color-secondary);
            box-shadow: var(--shadow-soft);
        }

        /* ---------- CTA banner ---------- */
        .cta-banner {
            background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
            color: #fff;
            border-radius: var(--radius-lg);
            padding: 3rem 2rem;
            text-align: center;
        }
        .cta-banner h2 { margin-bottom: .75rem; }
        .cta-banner p { opacity: .95; max-width: 520px; margin: 0 auto 1.75rem; }

        /* ---------- Contact ---------- */
        .contact-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: 1fr;
        }
        @media (min-width: 700px) {
            .contact-grid { grid-template-columns: repeat(2, 1fr); }
        }
        .contact-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--shadow-soft);
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }
        .contact-card strong { font-size: 1.05rem; }

        footer.site-footer {
            background: var(--color-text);
            color: rgba(255, 255, 255, .75);
        }
        .footer-inner {
            padding: 3rem 0 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: space-between;
        }
        .footer-brand { color: #fff; font-weight: 700; font-size: 1.15rem; margin-bottom: .5rem; }
        .footer-social { display: flex; gap: .9rem; margin-top: .75rem; }
        .footer-social a {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s ease;
        }
        .footer-social a:hover { background: var(--color-primary); }
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .12);
            padding: 1.25rem 0;
            text-align: center;
            font-size: .85rem;
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .drawer, .drawer-overlay, .album-card, .album-card .thumb img,
            .menu-toggle span, .btn, .service-card, .portfolio-item img {
                transition: none !important;
            }
        }
    </style>
</head>
<body>

    <header class="site-header">
        <div class="container">
            <a href="#inicio" class="brand">{{ $settings->site_name ?? config('app.name', 'Photo Commerce') }}</a>

            <nav class="desktop-nav">
                <a href="#inicio">Início</a>
                <a href="#servicos">Serviços</a>
                <a href="#portfolio">Portfólio</a>
                <a href="#albuns">Álbuns</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
                @if ($profile?->whatsapp_number)
                    <a class="btn btn-primary" href="https://wa.me/{{ preg_replace('/\D/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener">
                        Fale conosco
                    </a>
                @endif
            </nav>

            <button type="button" class="menu-toggle" id="menuToggle" aria-expanded="false" aria-controls="mobileDrawer" aria-label="Abrir menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <div class="drawer-overlay" id="drawerOverlay"></div>

    <aside class="drawer" id="mobileDrawer" aria-hidden="true">
        <div class="drawer-header">
            <span class="brand">Menu</span>
            <button type="button" class="drawer-close" id="drawerClose" aria-label="Fechar menu">&times;</button>
        </div>
        <nav class="drawer-nav">
            <a href="#inicio" data-drawer-link>Início</a>
            <a href="#servicos" data-drawer-link>Serviços</a>
            <a href="#portfolio" data-drawer-link>Portfólio</a>
            <a href="#albuns" data-drawer-link>Álbuns</a>
            <a href="#sobre" data-drawer-link>Sobre</a>
            <a href="#contato" data-drawer-link>Contato</a>
        </nav>
        <div class="drawer-footer">
            @if ($profile?->whatsapp_number)
                <a class="btn btn-accent" style="width:100%; justify-content:center;" href="https://wa.me/{{ preg_replace('/\D/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener">
                    Fale no WhatsApp
                </a>
            @endif
        </div>
    </aside>

    <main>
        <section id="inicio" class="hero">
            <div class="container">
                <span class="eyebrow">Fotografia profissional</span>
                <h1>{{ $settings->site_name ?? config('app.name', 'Photo Commerce') }}</h1>
                <p>{{ $settings->site_slogan ?? 'Registrando os melhores momentos da sua vida' }}</p>
                <div class="hero-actions">
                    <a class="btn btn-light" href="#portfolio">Ver portfólio</a>
                    @if ($profile?->whatsapp_number)
                        <a class="btn btn-outline" href="https://wa.me/{{ preg_replace('/\D/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener">
                            Solicitar orçamento
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section id="servicos">
            <div class="container">
                <h2 class="section-title">Serviços</h2>
                <p class="section-subtitle">Cobertura fotográfica sob medida para cada tipo de momento.</p>

                @if ($categories->isNotEmpty())
                    <div class="services-grid">
                        @foreach ($categories as $category)
                            @php
                                $icons = [
                                    'casamentos' => 'heart',
                                    'ensaios' => 'camera',
                                    'aniversarios' => 'gift',
                                    'corporativo' => 'briefcase',
                                    'gestante-newborn' => 'baby',
                                ];
                                $icon = $icons[$category->slug] ?? 'camera';
                                $whatsappText = rawurlencode('Olá! Gostaria de solicitar um orçamento para '.$category->name.'.');
                            @endphp
                            <div class="service-card">
                                <div class="service-icon">
                                    @include('components.icon', ['name' => $icon])
                                </div>
                                <h3>{{ $category->name }}</h3>
                                <p>{{ $category->description ?? 'Cobertura fotográfica completa, com edição profissional e entrega digital.' }}</p>
                                @if ($profile?->whatsapp_number)
                                    <a class="service-link" href="https://wa.me/{{ preg_replace('/\D/', '', $profile->whatsapp_number) }}?text={{ $whatsappText }}" target="_blank" rel="noopener">
                                        Solicitar orçamento →
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <p>Serviços em breve.</p>
                    </div>
                @endif
            </div>
        </section>

        <section id="portfolio" class="alt">
            <div class="container">
                <h2 class="section-title">Portfólio</h2>
                <p class="section-subtitle">Uma seleção de imagens recentes que mostram nosso olhar fotográfico.</p>

                @if ($portfolioPhotos->isNotEmpty())
                    <div class="portfolio-grid">
                        @foreach ($portfolioPhotos as $photo)
                            @if ($photo->image_url)
                                <div class="portfolio-item">
                                    <img src="{{ $photo->image_url }}" alt="{{ $photo->title ?? $photo->album?->title }}" loading="lazy">
                                    <div class="caption">{{ $photo->album?->title }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <p>Novas fotos em breve.</p>
                    </div>
                @endif
            </div>
        </section>

        <section>
            <div class="container">
                <h2 class="section-title">Como funciona</h2>
                <p class="section-subtitle">Um processo simples, do primeiro contato até a entrega das fotos.</p>

                <div class="process-grid">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <h3>Contato</h3>
                        <p>Conte sobre o seu evento e receba uma proposta personalizada.</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h3>Sessão</h3>
                        <p>Cobertura fotográfica no dia combinado, com toda tranquilidade.</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h3>Seleção</h3>
                        <p>Acesso ao álbum digital para visualizar e escolher as fotos.</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <h3>Entrega</h3>
                        <p>Download das fotos em alta resolução, prontas para guardar.</p>
                    </div>
                </div>
            </div>
        </section>

        @if ($profile)
            <section id="sobre" class="alt">
                <div class="container about-content">
                    <div class="about-card">
                        <h2 class="section-title" style="text-align:left; margin-bottom:1rem;">
                            {{ $profile->site_subtitle ?? 'Sobre nós' }}
                        </h2>
                        <p>{{ $profile->about_text ?? $profile->bio }}</p>
                    </div>
                    <div class="about-card">
                        <h3 style="margin-bottom:.75rem;">Especialidades</h3>
                        <div class="chips" style="justify-content:flex-start;">
                            @forelse ($categories as $category)
                                <span class="chip">{{ $category->name }}</span>
                            @empty
                                <span class="chip">Em breve</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section id="albuns">
            <div class="container">
                <h2 class="section-title">Álbuns</h2>
                <p class="section-subtitle">Coleções completas dos trabalhos mais recentes.</p>

                @if ($albums->isNotEmpty())
                    <div class="albums-grid">
                        @foreach ($albums as $album)
                            <div class="album-card">
                                <div class="thumb">
                                    @if ($album->cover_url)
                                        <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" loading="lazy">
                                    @endif
                                    @if ($album->category)
                                        <span class="badge">{{ $album->category->name }}</span>
                                    @endif
                                </div>
                                <div class="body">
                                    <h3>{{ $album->title }}</h3>
                                    @if ($album->event_location)
                                        <div class="meta">{{ $album->event_location }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <p>Novos álbuns em breve. Volte para conferir as próximas sessões fotográficas.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="alt">
            <div class="container">
                <div class="cta-banner">
                    <h2>Vamos registrar sua história?</h2>
                    <p>Entre em contato e monte, sem compromisso, uma proposta sob medida para o seu momento.</p>
                    @if ($profile?->whatsapp_number)
                        <a class="btn btn-light" href="https://wa.me/{{ preg_replace('/\D/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener">
                            Falar no WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section id="contato">
            <div class="container">
                <h2 class="section-title">Contato</h2>
                <p class="section-subtitle">Vamos planejar juntos o registro do seu próximo momento especial.</p>

                <div class="contact-grid">
                    @if ($profile?->whatsapp_number)
                        <div class="contact-card">
                            <strong>WhatsApp</strong>
                            <a class="btn btn-primary" style="align-self:flex-start;" href="https://wa.me/{{ preg_replace('/\D/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener">
                                Iniciar conversa
                            </a>
                        </div>
                    @endif

                    @if ($profile?->contact_email)
                        <div class="contact-card">
                            <strong>E-mail</strong>
                            <a href="mailto:{{ $profile->contact_email }}">{{ $profile->contact_email }}</a>
                        </div>
                    @endif

                    @if ($profile?->address)
                        <div class="contact-card">
                            <strong>Localização</strong>
                            <span>{{ $profile->address }}</span>
                        </div>
                    @endif

                    @if (!$profile?->whatsapp_number && !$profile?->contact_email)
                        <div class="empty-state">
                            <p>Canais de contato serão publicados em breve.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <div>
                <div class="footer-brand">{{ $settings->site_name ?? config('app.name', 'Photo Commerce') }}</div>
                <p style="max-width:320px;">{{ $settings->site_slogan ?? 'Fotografia profissional' }}</p>
                @if ($profile?->social_links)
                    <div class="footer-social">
                        @if (!empty($profile->social_links['instagram']))
                            <a href="{{ $profile->social_links['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram">
                                @include('components.icon', ['name' => 'instagram'])
                            </a>
                        @endif
                        @if (!empty($profile->social_links['facebook']))
                            <a href="{{ $profile->social_links['facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook">
                                @include('components.icon', ['name' => 'facebook'])
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            <div>
                <div class="footer-brand" style="font-size:1rem;">Navegação</div>
                <nav style="display:flex; flex-direction:column; gap:.5rem; margin-top:.5rem;">
                    <a href="#servicos">Serviços</a>
                    <a href="#portfolio">Portfólio</a>
                    <a href="#albuns">Álbuns</a>
                    <a href="#contato">Contato</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" style="color:var(--color-primary); font-weight:600;">Painel Administrativo</a>
                    @else
                        <a href="{{ route('login') }}" style="opacity:.6;">Acesso Restrito</a>
                    @endauth
                </nav>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ now()->year }} {{ $settings->site_name ?? config('app.name', 'Photo Commerce') }}
        </div>
    </footer>

    <script>
        (function () {
            var toggle = document.getElementById('menuToggle');
            var drawer = document.getElementById('mobileDrawer');
            var overlay = document.getElementById('drawerOverlay');
            var closeBtn = document.getElementById('drawerClose');
            var links = document.querySelectorAll('[data-drawer-link]');

            function openDrawer() {
                drawer.classList.add('is-open');
                overlay.classList.add('is-open');
                drawer.setAttribute('aria-hidden', 'false');
                toggle.setAttribute('aria-expanded', 'true');
                document.body.classList.add('drawer-locked');
            }

            function closeDrawer() {
                drawer.classList.remove('is-open');
                overlay.classList.remove('is-open');
                drawer.setAttribute('aria-hidden', 'true');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('drawer-locked');
            }

            toggle.addEventListener('click', function () {
                var isOpen = drawer.classList.contains('is-open');
                isOpen ? closeDrawer() : openDrawer();
            });

            closeBtn.addEventListener('click', closeDrawer);
            overlay.addEventListener('click', closeDrawer);
            links.forEach(function (link) {
                link.addEventListener('click', closeDrawer);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeDrawer();
                }
            });
        })();
    </script>
</body>
</html>

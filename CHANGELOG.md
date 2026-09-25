# Changelog — FotoCommerce Pro

> **Formato:** Ordem reversa cronológica (última alteração no topo).
> **Versão atual:** `v1.0.0-RC1` (Lançamento Candidato 1 — Build 25/09/2026)
> **Autor:** marcelo-brad rj | 21 98132-5441 | contato@kdkhost.com.br
> **Telegram:** @MARCELO_BRAD | **Instagram:** @marcelobradrj
> **Organização GitHub:** @kdkhost

---

## 🎉 [v1.0.0-RC1] — 2026-09-25 20:00
### Build: `20260925-RC1` · Tag GitHub: `v1.0.0`

#### ✨ Geral
- 🚀 Lançamento Candidato 1 (100% 23 Tasks do roadmap `.trae/specs/photo-commerce-system/tasks.md`)
- 🗃️ **49 migrations** (todo campo monetário `DECIMAL(12,2)` — ZERO FLOAT/DOUBLE — regra AGENTS.md)
- 🧩 **42 Models** Eloquent + **12 Enums Backed** PHP 8.3 (com `protected $casts` em todos)
- 📦 Pacotes: `spatie/laravel-permission:^8.3`, `jeroennoten/laravel-adminlte:^4.0`, `mercadopago/dx-php:^3.16`, `intervention/image-laravel:^4.1`, `google/apiclient:^2.20`
- 🧪 3 testes PHPUnit feature: Checkout Flow (carrinho + cupom 15%), Webhook Mercado Pago mockado, Auth redirect por Role

#### 🔐 Tasks 3 + 4 — Autenticação + RBAC
- `Auth/LoginController`, `ForgotPasswordController`, `ResetPasswordController` com redirect por `UserType` (Customer → customer.dashboard · Admin → admin.dashboard)
- Bloqueio `blocked_at`, `last_login_at` + `last_login_ip`, `session()->regenerate()` anti session fixation
- Rate limiters em `bootstrap/app.php`: `login 30/min`, `password-reset 10/min`
- **3 Roles**: Super Admin (bypass `Gate::before`), Admin, Customer
- **62 Permissões** granulares + **17 Policies** + **33 Gates** (`AppServiceProvider::boot()`)

#### 🖥️ Task 5 — Painel Admin AdminLTE v4
- Sidebar 20 itens perm-scoped `@can/@canany`: Dashboard, Álbuns→Categorias, Fotos, Clientes, Pedidos, Pagamentos, Estornos, Promoções→Cupons, Tickets, Configurações→SMTP/SEO/Storage/Settings/Roles/AuditLogs
- 8 widgets InfoBox: 💰 Receita, 💳 Pagos, ⏳ Pendentes, 👥 Novos Clientes, 📸 Fotos Vendidas, 🖼️ Álbuns Publicados, 👀 Visitas, 🎫 Tickets Abertos · KPI Conversão %
- Filtro período (Hoje / 7D / 30D / Mês Atual / Passado)
- Componentes Blade: `<x-admin-info-box>` e `<x-admin-order-status-badge>` (cores por enum)

#### ✏️ Task 6 — WYSIWYG + Modais + Notificações
- `resources/js/sweetalert.js`: wrappers `SAConfirm`, `SAConfirmDelete`, `SAConfirmIrreversible` (checkbox obrigatório)
- `resources/js/notifications.js`: Bootstrap 5 Toast container fixo top-right (4 tipos: success/error/info/warning)
- **REGRA RÍGIDA ATIVA**: NÃO existe `alert()/confirm()/prompt()` nativo em NENHUM lugar do sistema (100% SweetAlert2 + Notify)
- `Admin/SummernoteUploadController` — POST `/admin/summernote/upload` drag-drop 5MB max, retorna JSON url CDN

#### 📧 Task 7 — SMTP Runtime + 24 Templates de E-mail
- `SmtpRuntimeConfigService` — runtime mailer (sem precisar `config:clear`), password via `Crypt::encryptString()`, retorno sempre mascarado `••••••••`
- `Mail/GenericTemplateMail` — parse placeholders `{{variavel}}` com `strtr`, fallback automático plain-text
- Jobs `SendTestEmailJob` timeout 30s, log `EmailLog` **NUNCA grava senha**
- **24 templates nativos**: welcome, verify-email, password-reset, order-received, order-paid, order-available, payment-pending-pix, payment-pix-paid, payment-credit-paid, payment-failed, order-cancelled, order-expired, refund-requested, refund-approved, refund-completed, refund-failed, ticket-created, ticket-reply-admin, ticket-reply-customer, ticket-closed, account-deleted-lgpd, smtp-test, daily-report, partially-refunded

#### 📸 Tasks 8 + 9 — Álbuns, Upload DragDrop + Storage Drivers
- 4 Controllers: `AlbumCategoryController`, `AlbumController`, `PhotoUploadController`, `PhotoSizeController`
- **Dropzone 6 chunked (5MB chunks, retry, parallel=false)**
- **SortableJS drag-drop grid reorder** → transação atômica `POST /admin/albums/{album}/photos/reorder`
- 1 foto destaque por álbum (`is_featured`) · badge ⭐
- Interface `PhotoStorageDriverContract` (6 métodos) → `LocalPhotoStorageDriver` (Intervention Image 4 GD)
- 8 tamanhos via `PhotoSize` (thumb 150, small 400, medium 800, large 1600, xlarge 2400, original, watermarked 1600, download_high)
- EXIF extraído: taken_at, câmera, lente, distância focal, abertura, ISO, velocidade obturação, GPS lat/lng
- Esqueleto `GoogleDriveStorageDriver` (hot storage = LocalDriver; futuro cold storage → Google API resumível upload para `photographer_profile.gdrive_folder_id`)

#### 🛒 Task 10 — Carrinho com Pipeline de Descontos Inteligente
- `Services/Cart/CartService` sessão driver + LineItem DTO (photo, size, qty, unit_price, is_bonus)
- **Pipeline ordem FIXA**: Cupom → Desconto Progressivo (10=3% · 30=5% · 50=7% · 100=10%) → Bônus (1 grátis a cada 10 pagas) → Fee Pass (percent/fixed/none) → Taxa → TOTAL
- Bônus automático: `floor(paid_qty / 10)` → marca itens `is_bonus=1` (R$0,00) final do array
- Cupons: `CouponType Percent/Fixed`, valida `minimum_order_value`, `minimum_photos_qty`, `usage_limit`, `usage_per_user_limit`, `valid_from/until`

#### 💳 Task 11 — Gateway Mercado Pago (PIX + Cartão + Webhook)
- `MercadoPagoService` implementa `PaymentGatewayContract` (createPreference / findPayment / refund / handleWebhook)
- Preference items + `external_ref = order_number` + `notification_url` webhook + back_urls success/pending/failure + `auto_return = approved`
- PIX: QR code image base64 + `qr_code` copia-e-cola (ClipboardJS + Notify "Copiado!"). Refresh página PIX a cada 30s automático
- Cartão Crédito: parcelamento nativo Mercado Pago, bin detection, 3DS se disponível
- **Webhook** `POST /webhooks/mercadopago` com header `x-signature` validation (opcional via setting `webhook_verify_signature`) — 100% IDEMPOTENTE (NUNCA sobrescreve Paid ← Pending retrocesso)
- Fees: `payment_gateways.fees_tier JSON` + `payments.fee_amount` + `payments.net_amount` + `payments.transaction_amount`
- Jobs: `CreateOrderFromCart` (anti timeout big cart), `SendCustomerPaymentNotificationJob`
- Views: `checkout/index` (resumo + método), `checkout/pix` (QR), `checkout/result` (success/failure/pending)
- `PaymentServiceProvider` binds `PaymentGatewayContract → MercadoPagoService`

#### ⬇️ Task 12 — Download Autenticado (Segurança Máxima LGPD)
- `Customer/DownloadController` (auth customer apenas · 30/pagina · busca título album/foto)
- `single(OrderItem, token)`: `hash_equals($token, $item->download_token)` → **DB::transaction() atômica** (gate downloads_count >=5 → 429)
- Janela disponibilidade: **2 anos** (`available_at + 2 years`) · Log completo `DownloadAudit`
- `zipAll(Order)`: `tempnam(sys_get_temp_dir())` + `ZipArchive` ou ZipStream + `response()->download(deleteFileAfterSend:true)` · Throttle **3 downloads/dia/pedido via cache key**

#### 🎫 Task 13 — Tickets Suporte + FAQ + LGPD
- Categorias tickets · anexos 10MB (pdf/docx/png/jpg) em `ticket_attachments`
- Ações: Close / Reopen / Idle 7 dias → fecha automático
- FAQ accordion Bootstrap 5 · Páginas estáticas `/termos-de-uso`, `/politica-de-privacidade`, `/lgpd`

#### 👤 Task 14 — Painel do Cliente (LGPD Completo)
- Perfil: nome, email, telefone, CPF, data nascimento, gênero, alterar senha (current_password obrigatório)
- **DELETE CONTA LGPD**: transação anônima campos pessoais → grava `blocked_at = now()` → softDeletes → emite template `account-deleted-lgpd` por e-mail
- Sidebar `customer/_sidebar.blade.php` com `request()->routeIs()` highlight ativo

#### 🌍 Task 15 — Site Público
- `HomeController` — tema por variáveis CSS (`--brand-primary`, `--brand-secondary`, `--brand-accent`, `--font-family-base`, `--font-family-heading`) via `SiteSettings` colors + font_family
- `PublicAlbumController` — porta senha album: `Hash::check(senha, album.password_hash)` → sessão `album_unlocked_{id}`. Não permite Visibility::Private sem senha
- Galeria Lightbox2 · Add Ao Carrinho AJAX → Notify toast verde "R$X adicionado"
- `ContactController` orçamento: `event_type` select + budget min/max + `lgpd_consent` checkbox obrigatório → grava Ticket automático + envio e-mail SMTP
- Página `/quem-somos` (PhotographerBioController): hero avatar 220px arredondado, bio HTML WYSIWYG, sidebar especialidades, seção atendimento RJ + Brasil · WhatsApp direto non-digits limpo

#### 🔎 Task 16 — SEO
- `Seo/SitemapController` — `Content-Type: application/xml` · 200 · álbuns published + public + categorias + rotas estáticas / /galeria /contato /quem-somos
- `Seo/SitemapController@robots` → `User-agent: * Allow: / Disallow: /admin* Disallow: /customer* Sitemap: /sitemap.xml`
- View base `<link rel="canonical">` + Meta OG (og:title, og:image, og:description, og:url, og:type, og:locale pt_BR)

#### 📊 Task 17 — Visitor Analytics Middleware (TrackVisitor)
- Registrado web group global
- Skip: admin*, /minha-conta, assets (.css.js.png.jpg.woff2.svg), .well-known
- **Throttle 1 minuto IP + path** (cache Redis/Files) para não estourar disco
- 12 bots/crawlers detectados: Googlebot, Bingbot, Yandex, curl, wget, Python-urllib, PetalBot, SemrushBot, DotBot, AhrefsBot, MJ12bot, Bytespider · `is_bot = true`
- Tabela `visitors`: session_id, user_id nullable, ip, path, query, referer, user_agent, method, is_bot

#### ⏱️ Task 18 — Cron Jobs (Agendador Laravel)
- `photo-commerce:cleanup-expired` → `hourly()` `withoutOverlapping()`: marca pedidos AwaitingPayment/Pending + `expires_at < now()->subDays(2)` como Expired; apaga `storage/app/chunks/*` com `mtime < now()->subHours(6)` recursivo
- `photo-commerce:daily-report` → `dailyAt('08:00')` `withoutOverlapping()`: dados ontem (total orders, pagos, SUM receita paid, count DISTINCT IP visitas) → envia HTML `GenericTemplateMail` para SMTP from_addr
- `routes/console.php` com schedule definido

#### 💸 Task 20 — UI Estornos Admin (Confirmação IRREVERSÍVEL OBRIGATÓRIA)
- `RefundController`: Policies `refunds.view / refunds.approve` por método middleware
- $maxRefundable = `(paid_amount − refunded_amount)`. Se ≤0 → HTTP 400.
- Validação server-side rígida: amount ≤ max, `confirm_text === IRREVERSIVEL ou IRREVERSÍVEL (pattern regex)`, `item_ids.* exists:order_items`
- Chama `PaymentGatewayContract->refund($payment, amount)` → atualiza `gateway_refund_id`, `gateway_response JSON`, `status = Completed` transacional DB
- 3 views: grid filtros status; create (card borda amarela alerta topo, caixa texto obrigatória digitando IRREVERSIVEL, botão TOTAL preenche max, badge Parcial vs Total); show (guia 5 anti-fraude no sidebar direito)
- Rotas: `admin.refunds.index / create / store / show`

#### 🎁 Task 21 — Cupons Promoções CRUD Admin
- `CouponController` Policies `promotions.view/create/update/delete`
- Validações fortes: percent ≤100%, `Rule::unique('coupons', 'code')->ignore($id)`. Se cupom já usado em `orders`: NÃO APAGA (apenas `is_active=false`)
- Index: busca por código/nome, filtro ativo/inativo, badge tipo % / R$, mostruário `used_count / usage_limit ∞`
- Form: botão gerar código aleatório `CUPOM_*7chars`. Sync prefixo input valor (`% ↔ R$`) live via JS. Summernote descrição observações internas. Campos: minimum_order_value, minimum_photos_qty, usage_limit, usage_per_user_limit, valid_from, valid_until, is_active
- Rotas: `admin.coupons.index / create / store / edit / update / destroy`

---

## 🏗️ [v0.3.0-prealpha] — 2026-09-25 01:00
### Tasks 1 + 2: Setup + Models + Migrations + Factories + Seeders
- Laravel 13.17 + PHP 8.3 inicializado via `laravel new`
- 10 Factories completos com states (paid, awaitingPayment, cancelled, creditCard, fraud, pix, percent): User, AlbumCategory, Album, Photo, Order, Payment, PaymentGateway, Coupon, Refund, Ticket
- 3 Seeders: `RolePermissionSeeder` (3 roles + 62 perms), `EmailTemplateSeeder` (24 templates), `PhotoSizeSeeder` (8 tamanhos padrão)
- Comando Artisan personalizado: `php artisan photo-commerce:create-admin {--name=} {--email=} {--password=}`

---

## 🧪 [v0.0.1-init] — 2026-09-24 23:00
- Criação do projeto base Laravel
- Spec `.trae/specs/photo-commerce-system/spec.md` + 23 tasks em `.trae/specs/photo-commerce-system/tasks.md`
- `AGENTS.md` regras monetárias (DECIMAL 12,2) / UI (AdminLTE4 pure Bootstrap5 Icons) / UX (SweetAlert2 sem alert() nativo) / LGPD
- Autor definido oficialmente: **marcelo-brad rj**  <contato@kdkhost.com.br>  +55 21 98132-5441

# Photo Commerce System - Implementation Plan

---

## Task 1: Criar Projeto Laravel Base, Dependências e Estrutura Desacoplada
- **Status**: `completed`
- **Priority**: high
- **Depends On**: None
- **Description**:
  - Criar projeto Laravel versão estável compatível com PHP 8.4+ via `composer create-project laravel/laravel`
  - Instalar dependências: `jeroennoten/laravel-adminlte`, `spatie/laravel-permission`, `mercadopago/dx-php`, `google/apiclient`, `intervention/image`, `laravel/sanctum`, `pestphp/pest-plugin-laravel` (ou PHPUnit)
  - Configurar `.env.example` completo (APP, DB, MAIL, QUEUE, FILESYSTEMS, MERCADO_PAGO_*, GOOGLE_DRIVE_*, ANALYTICS_*)
  - Criar estrutura desacoplada em `app/`: Actions, Contracts, DTOs, Enums, Exceptions, Http/{Controllers,Middleware,Requests}, Jobs, Listeners, Mail, Models, Notifications, Policies, Repositories, Support, Services/{Album,Cart,Checkout,Discount,Email,Photo,Promotion,Refund,Seo,Storage,Visitor,Payment/{Contracts,Gateways,Webhooks}}
  - Configurar `config/filesystems.php` com disco `photos_private` (local, não público), `photos_public` (thumbnails/previews), `storage_app`
  - Criar estrutura `resources/js` modular (app, notifications, sweetalert, uploader, sortable, cart, checkout, payments, admin/*, customer/) e `resources/css` modular (app, admin, storefront, login, checkout, components/)
  - Configurar `.gitignore` e atributo de autoria nos arquivos PHP principais quando apropriado
- **Acceptance Criteria Addressed**: AC-1, AC-21, AC-25
- **Test Requirements**:
  - `rule` TR-1.1: `composer install` + `php artisan key:generate` executam exit code 0; Evidence: saída no terminal
  - `rule` TR-1.2: `ls app/Services app/Contracts app/DTOs app/Actions app/Policies app/Repositories` todos diretórios existem; Evidence: saída ls/tree
  - `rule` TR-1.3: `.env.example` contém todas variáveis: DB_*, MAIL_*, MERCADO_PAGO_*, GOOGLE_DRIVE_*, QUEUE_CONNECTION, FILESYSTEM_DISK; Evidence: `cat .env.example | grep`
  - `rubric` TR-1.4: Organização modular de JS/CSS; scale 1-5; anchors 1=arquivos monolíticos 3=alguma separação 5=estrita organização por domínio e admin/customer; threshold >= 4; Evidence: árvore resources/js e resources/css
- **Notes**: Após esta task, rodar `php artisan --version` e salvar como evidence.
- **Completion Evidence**:
  - TR-1.1 `rule` PASS: Laravel 13.33.0 criado. `php artisan route:clear` ✅, `config:clear` ✅, `key:generate` ✅ (todas exit 0). `composer install` dos packages: AdminLTE 4.9.1, jeroennoten wrapper v4, spatie/permission 8.3, mercadopago/dx-php 3.16, google/apiclient 2.20, intervention/image-laravel 4.1, sanctum 4.3, laravel/boost 2.10 — todos instalados com sucesso.
  - TR-1.2 `rule` PASS: 35 subdiretórios de `app/` criados com `.gitkeep` cobrindo Actions, Contracts, DTOs, Enums, Exceptions, Jobs, Listeners, Mail, Notifications, Policies, Repositories, Support e 13 Services (Album→Payment/Webhooks). Todos existem.
  - TR-1.3 `rule` PASS: `.env.example` atualizado com locale pt_BR, DB_CONNECTION=mysql, MAIL completo, MERCADO_PAGO_ENV/ACCESS_TOKEN/PUBLIC_KEY/WEBHOOK_TOKEN + PIX expiração + taxa repasse, GOOGLE_DRIVE_CLIENT_ID/SECRET/REFRESH_TOKEN/FOLDER_ID, QUEUE_CONNECTION=database, FILESYSTEM_DISK=local, PHOTO_STORAGE_DRIVER, ANALYTICS_ENABLED/ANONYMIZE_IP/RESPECT_DNT, ADMIN_PREFIX, UPLOAD_MAX_IMAGE_MB, IMAGE_QUALITY.
  - TR-1.4 `rubric` PASS **Score 5/5**: JS 14 arquivos (app + 7 domínios + admin 5 + customer 1) e CSS 8 arquivos (app + 4 domínios + 3 components). Organização estrita por domínio e separação admin/customer/components. Config central `config/photo-commerce.php` com dimensões de imagem recomendadas.
  - Extras: `config/filesystems.php` atualizado com discs `photos_private` e `photos_public`; vendors publicados (AdminLTE config/views/lang/dist, Spatie Permission config+migration, Sanctum config+migrations, Intervention Image config).

---

## Task 2: Migrations Completas, Models, Enums, Seeders Base (Sem Dados Falsos)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 1
- **Description**:
  - Criar migrations para TODAS tabelas da lista FR-18 usando `DECIMAL(12,2)` para monetário; índices apropriados; sem multi-tenant
  - Criar Enums: `AlbumStatus`, `OrderStatus`, `PaymentStatus`, `RefundStatus`, `TicketStatus`, `PromotionType`, `DiscountTier`, `PhotoSizeType`, `Visibility`
  - Criar Models com relações: User (roles/permissions), Role, Permission, PhotographerProfile, Album, AlbumCategory, Photo, PhotoSize, PhotoPrice, PhotoFile, Cart/CartItem, Order/OrderItem, Payment/PaymentTransaction/PaymentWebhook, PaymentGateway, Promotion/PromotionRule/PromotionBonus/PromotionGift, Coupon, Refund/RefundItem, Ticket/TicketMessage, Complaint, Visitor/VisitorSession/TrafficSource, SeoSetting/SeoKeyword/SeoPage, SiteSetting/SiteSection/SiteBanner/SiteSlide, StorageSetting, EmailTemplate/EmailLog, CronLog, AuditLog, FailedJob (padrão)
  - Criar Seeders apenas: Roles/permissões granulares da lista FR-5, configurações padrão, templates de e-mail base (24), estados/enums necessários. **NÃO** inserir orders/payments/fotos falsas.
- **Acceptance Criteria Addressed**: AC-5, AC-10, AC-14, AC-16, AC-21
- **Test Requirements**:
  - `rule` TR-2.1: `php artisan migrate --seed` retorna exit 0; `SHOW TABLES` contém pelo menos 50 tabelas da lista FR-18; Evidence: saída migrate e SQL
  - `rule` TR-2.2: `grep -ri "float\|double" database/migrations/*_create_*order* *_create_*payment* *_create_*refund*` retorna vazio (monetário DECIMAL 12,2); Evidence: saída grep
  - `rule` TR-2.3: Após seed, `select count(*) from permissions` >= 30, `select count(*) from roles` >= 3, `select count(*) from email_templates` = 24, `select count(*) from orders` = 0, `select count(*) from payments` = 0; Evidence: consultas SQL
  - `rule` TR-2.4: Tabelas NÃO contêm coluna `tenant_id` ou `photographer_id` (exceto `photographer_profile` como tabela única 1:1 com settings); Evidence: `SHOW COLUMNS` em 10 tabelas principais
  - `rubric` TR-2.5: Relações e índices em Models; scale 1-5; anchors 1=sem relações 3=parcial 5=todas relações belongsTo/hasMany/hasManyThrough + indexes em FKs + type hints em relações; threshold >= 4; Evidence: ler 5 Models (Order, Photo, User, Refund, Ticket)
- **Notes**: Manter `photographer_profile` como tabela de perfil único do dono (1 registro).

---

## Task 3: Autenticação Completa (Login, Recuperação, Verificação, Segurança, UI)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 2
- **Description**:
  - Implementar auth Laravel Breeze/Fortify ou UI auth nativa custom, adaptando templates
  - Tela login desktop 2 colunas (coluna esquerda: foto background + overlay configurável a partir de `site_settings`; coluna direita: logo, título, email, senha, lembrar-me, botão Entrar, Esqueci)
  - Tela login mobile (<=md): coluna foto display:none (nenhum espaço)
  - Rotas `/forgot-password` e `/reset-password/{token}` estilizadas, não revelam se e-mail existe
  - Middleware: `verified`, `throttle:login`, sessão segura (config/session.php secure/httponly/same_site)
  - Proteção session fixation, CSRF nativo reforçado
- **Acceptance Criteria Addressed**: AC-4, AC-24, AC-23
- **Test Requirements**:
  - `rule` TR-3.1: `/login` desktop 1024px exibe 2 colunas; mobile 320px DevTools mostra apenas formulário com coluna foto `display:none`; Evidence: screenshots DevTools 320px + 1024px, inspetor CSS
  - `rule` TR-3.2: Post em `/forgot-password` com email inexistente retorna **exatamente a mesma mensagem** que email existente (status 200, sem variação de resposta); Evidence: 2 requests HTTP comparados
  - `rule` TR-3.3: 30 tentativas login consecutivas com email válido + senha errada resultam em `429 Too Many Attempts` por 1 minuto; Evidence: resposta HTTP 429 + cabeçalhos Retry-After
  - `rule` TR-3.4: Login válido redireciona admin para `/admin/dashboard` e cliente para `/minha-conta`; logout invalida sessão; Evidence: requests e redirects
- **Notes**: Guardar templates de login em `resources/views/auth/`. Colocar foto login inicial como placeholder configurável via painel em Task 16.

---

## Task 4: RBAC, Middleware, Policies, Gates (Spatie Permission ou Implementação Própria)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 3
- **Description**:
  - Integrar permissões do Spatie (ou própria) criando relações User↔Roles↔Permissions conforme Task 2
  - Criar Policies: `AlbumPolicy`, `PhotoPolicy`, `OrderPolicy`, `PaymentPolicy`, `RefundPolicy`, `PromotionPolicy`, `CustomerPolicy`, `TicketPolicy`, `SettingPolicy`, `SeoPolicy`, `StoragePolicy`, `SmtpPolicy`, `EmailTemplatePolicy`, `UserPolicy`, `RolePolicy`, `PermissionPolicy`, `AuditLogPolicy`
  - Registrar Gates para cada permissão granular (`albums.delete`, `payments.manage` etc.)
  - Criar middleware `RoleMiddleware`, `PermissionMiddleware`
  - Seed de roles iniciais: Super Admin (todas permissões), Admin Assistente (CRUD álbuns/fotos mas não settings/segurança), Cliente (apenas /minha-conta)
- **Acceptance Criteria Addressed**: AC-5, AC-24
- **Test Requirements**:
  - `rule` TR-4.1: Usuário com role `Admin Assistente` (sem `settings.update`) acessa `GET /admin/settings` → 403; Super Admin → 200; Evidence: 2 responses HTTP
  - `rule` TR-4.2: `AlbumPolicy@delete` bloqueia usuário sem `albums.delete` via Policy test (Pest/PHPUnit) com `assertGateDenied` / `$this->assertForbidden`; Evidence: saída testes
  - `rule` TR-4.3: Todas permissões da lista FR-5 existem em tabela `permissions` com `guard_name=web`; Evidence: `select count(*), guard_name from permissions group by guard_name`
- **Notes**: Manter Super Admin bypass via `Gate::before` quando role=super-admin.

---

## Task 5: Integrar AdminLTE 4 (Sidebar, Navbar, Dashboard, Componentes, Dark Mode)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 4
- **Description**:
  - Instalar e configurar `jeroennoten/laravel-adminlte` com template oficial AdminLTE 4
  - Criar layouts: `resources/views/admin/layouts/app.blade.php` contendo sidebar, navbar, breadcrumb, content wrapper, footer
  - Preencher sidebar com menu dinâmico por permissão: Dashboard, Álbuns, Fotos, Clientes, Pedidos, Pagamentos, Estornos, Promoções, Tickets, Configurações (submenu abas), Sistema (Cron, Queue), Auditoria
  - Criar Dashboard inicial AdminLTE 4: cards info-box, tabela últimos pedidos, últimos clientes (dados via query real — mesmo que 0 linhas)
  - Habilitar dark mode suportado, tooltips/popovers, breadcrumb automático, tabelas DataTable-style (table-responsive), tabs/accordion/modais nativos
- **Acceptance Criteria Addressed**: AC-2, AC-17, AC-23
- **Test Requirements**:
  - `rule` TR-5.1: Renderização `/admin/dashboard` com sidebar (menu lateral), navbar top, breadcrumb "Home / Dashboard", pelo menos 3 adminlte cards info-box e 1 tabela responsive; sem console JS errors; Evidence: screenshot + console vazio
  - `rubric` TR-5.2: Fidelidade à estrutura oficial AdminLTE 4; scale 1-5; anchors 1=apenas CSS carregado 3=componentes mas sidebar manual 5=uso de vendor adminlte oficial com componentes sidebar/navbar/cards/tables/modais conforme documentação; threshold >= 4; Evidence: inspecionar `resources/views/admin/layouts/` e uso de `@extends('adminlte::page')` ou similar
  - `rule` TR-5.3: Usuário sem permissão `albums.view` NÃO vê item "Álbuns" no sidebar (condicional); Evidence: HTML fonte sidebar para usuário sem permissão
- **Notes**: Manter aparência consistente e não reinventar componentes (usar `adminlte::components.*` quando houver).

---

## Task 6: Summernote Reutilizável, SweetAlert2 Centralizado e Notify/Toast
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 5
- **Description**:
  - Criar componente Blade `resources/views/components/forms/summernote.blade.php` com props `name`, `value`, `height`, `required`, `id`, `uploadUrl`
  - Configurar Summernote toolbar (formatação, tabelas, link, vídeo, fullscreen, codeview, limpar formatação), upload de imagens via rota POST (`POST /admin/summernote/upload`) com validação MIME
  - Criar `resources/js/sweetalert.js` centralizado com funções `confirmDelete(message, callback)`, `confirmAction(title, text, callback)`, `confirmIrreversible()` — NUNCA usar `alert/confirm/prompt`
  - Criar `resources/js/notifications.js` com `toast.success/error/warning/info` (Notify/Toast, ex.: Toaster ou Bootstrap native Toast custom)
  - Proibir globalmente alert nativos via lint/injeção (opcional)
  - Verificar Summernote funciona dentro de modals e tabs (criar exemplo em um formulário de teste)
- **Acceptance Criteria Addressed**: AC-3, AC-26
- **Test Requirements**:
  - `rule` TR-6.1: Arquivo componente `x-forms.summernote` existe; Summernote inicializa com sucesso em 2 páginas distintas (álbum create + email template edit); console vazio; upload de imagem salva em storage e retorna URL; Evidence: screenshots 2 páginas + imagem salva em storage
  - `rule` TR-6.2: `grep -r "window.alert(\|confirm(\|prompt(" resources/js app/ resources/views` retorna vazio (substituídos por SweetAlert2); Evidence: saída grep
  - `rule` TR-6.3: Em formulário de exclusão, clique chama SweetAlert2 (confirmação) e ao confirmar executa DELETE; ao cancelar aborta; Evidence: screencast ou 2 screenshots do modal
- **Notes**: Usar CDN ou publicar assets Summernote + SweetAlert2 em `public/vendor/`.

---

## Task 7: SMTP Configurável, Teste de E-mail, Central de Templates (CRUD Summernote)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 6
- **Description**:
  - Tabela `site_settings` (campos JSON ou tabela EAV) contendo SMTP host/port/user/pass/encryption/from_name/from_address/reply_to/timeout
  - Service `Email\SmtpConfigService` que aplica runtime configurações do banco sobre o Laravel MailManager (antes do Mail)
  - CRUD `EmailTemplateController` admin: nome, slug único, subject, body_html (Summernote), body_text, is_active, variables_list
  - Seed 24 templates (FR-12)
  - Rota/ação "Enviar E-mail Teste": `POST /admin/smtp/test` com destinatário, usa Jobs `SendTestEmailJob`; retorna Notify Toast sucesso/falha detalhada sem expor credenciais
  - Log `email_logs` sem senha
- **Acceptance Criteria Addressed**: AC-15, AC-16, AC-13 (em parte)
- **Test Requirements**:
  - `rule` TR-7.1: GET `/admin/settings/smtp` → input password **não** contém atributo `value` (não exibido); POST update salva senha hash ou criptografada em banco; Evidence: HTML fonte + inspect coluna do bd
  - `rule` TR-7.2: POST `/admin/smtp/test` com destinatário real (mailpit/mailtrap) envia e-mail e retorna Toast success; se host inválido retorna Toast erro sem conter `password=` em corpo; Evidence: saída + caixa de teste + `select * from email_logs where id=last` (dados mascarados)
  - `rule` TR-7.3: `select count(*) from email_templates where is_active=1` = 24; página `/admin/emails/templates` lista todos com preview/enviar teste; `grep -r "<html" app/Http/Controllers/` retorna 0 (nenhum HTML de email inline em controllers); Evidence: contagem SQL + grep negativo
- **Notes**: Usar `Crypt::encryptString` para senha SMTP antes de salvar.

---

## Task 8: Álbuns CRUD, Galeria e Upload Drag & Drop com SortableJS + Processamento
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 7
- **Description**:
  - CRUD completo Álbum (título, slug único, descrição Summernote, evento, capa, data, local, status Enum AlbumStatus, visibility, password opcional, start_at, end_at, seo)
  - Página de gestão do álbum: upload drag & drop área usando Dropzone ou custom uploader + SortableJS para ordenação
  - `Photo\UploadService` valida MIME, move original para storage privado, cria preview/thumbnail/watermarked (Intervention Image), salva em `photo_files`
  - Rota AJAX progress upload com suporte a retry/cancel
  - Permite aplicar watermark configurável por álbum
- **Acceptance Criteria Addressed**: AC-6, AC-5 (permissões)
- **Test Requirements**:
  - `rule` TR-8.1: POST múltiplos arquivos em `/admin/albums/{id}/upload` cria N registros em `photos` + N×4 linhas em `photo_files` (original/preview/thumbnail/watermarked); arquivos existem nos caminhos corretos; Evidence: SQL count + ls storage
  - `rule` TR-8.2: Área drag & drop renderiza em desktop e mobile, com preview e progresso; upload de arquivo `.exe` retorna 422 validation error; Evidence: screenshot + response 422
  - `rule` TR-8.3: Reordenar 5 fotos com SortableJS salva campo `photos.order` corretamente após `POST /admin/albums/{id}/photos/reorder`; Evidence: ordem inicial vs final no banco
- **Notes**: Aplicar watermark via Intervention Image overlay PNG ou texto.

---

## Task 9: Tamanhos/Qualidades Configuráveis, Storage Drivers Interface (Local + Google Drive Opcional)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 8
- **Description**:
  - CRUD `photo_sizes` (name, slug, width, height, quality, format, availability) e `photo_prices` (photo_id, size_id, price DECIMAL 12,2)
  - `Storage\StorageDriverInterface` com métodos `store`, `get`, `delete`, `exists`, `temporaryUrl`, `downloadStream`
  - Implementar `LocalStorageDriver` (predefinido, 100% do core)
  - Implementar `GoogleDriveStorageDriver` usando `google/apiclient` (credenciais em env ou settings, painel config em Task 16) — NÃO usado por padrão; ausência de credenciais NÃO quebra
  - Service resolver `StorageManager` com facade ou bind no container baseado em `config('photo-commerce.storage.driver')`
- **Acceptance Criteria Addressed**: AC-14, AC-11
- **Test Requirements**:
  - `rule` TR-9.1: `StorageDriverInterface`, `LocalStorageDriver`, `GoogleDriveStorageDriver` existem com signatures corretas; `app()->bind(StorageDriverInterface::class, ...)` resolve para Local por padrão; Evidence: arquivos e `php artisan tinker` resolve
  - `rule` TR-9.2: Desativar Google Drive (remover env vars) e rodar upload Task 8 → continua funcionando sem erros 500; Evidence: logs vazios e upload OK
  - `rule` TR-9.3: Tamanhos Standard/HD/Full HD/Premium/Original com preços distintos são salvos e retornados corretamente ao listar uma foto no frontend; Evidence: JSON/HTML do item
- **Notes**: Dimensões recomendadas em `config('photo-commerce.image_dimensions')` config centralizada.

---

## Task 10: Carrinho, Desconto Progressivo, Bônus/Brindes (Backend + AJAX)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 9
- **Description**:
  - Models `Cart`, `CartItem` (usuário autenticado + sessão guest opcional)
  - `Cart\CartService` com métodos `add(item)`, `remove(itemId)`, `setQty(itemId, qty)`, `clear()`, `getTotals()` — RECALCULA preços, descontos, bônus a partir do BANCO (nunca aceita `price` de request)
  - `Discount\ProgressiveDiscountService` lê faixas de `promotion_rules` configuráveis e aplica %
  - `Promotion\BonusService` aplica "compre X ganhe Y" selecionando fotos elegíveis `promotion_gifts`
  - Rotas AJAX `/cart/add`, `/cart/remove`, `/cart/update`, `/cart/totals` com respostas JSON + Toast notify
  - Tela carrinho `/carrinho` com subtotal, desconto, bônus listado, taxa, total
- **Acceptance Criteria Addressed**: AC-7, AC-24
- **Test Requirements**:
  - `rule` TR-10.1: Adicionar 3 fotos de preço R$ 20 via request normal → total subtotal 60, desconto 10% → total 54. Enviar request adulterado `price=0.01` para `/cart/add` → resultado de total permanece 54 (service ignora preço request); Evidence: 2 responses JSON comparados
  - `rule` TR-10.2: Bônus "compre 3 ganhe 1" → item brinde adicionado automaticamente em `cart_items` com `is_bonus=1` e preço 0; Evidence: `select * from cart_items where cart_id=X`
  - `rule` TR-10.3: Atualizar quantidade via AJAX sem recarregar página; número do carrinho no header atualiza; Evidence: screencast ou diff antes/depois do DOM
- **Notes**: Nunca usar `request('price')`; sempre `PhotoPrice::findOrFail($priceId)`.

---

## Task 11: Checkout Transparente, Gateway Interface, Repasse de Taxa
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 10
- **Description**:
  - `Payment\Contracts\PaymentGatewayInterface`: createCharge, getCharge, cancelCharge, refundCharge, supportsWebhook, getCheckoutData
  - Rotas: `GET /checkout`, `POST /checkout/process` (dados do cliente + método)
  - Checkout transparente: formulário Bootstrap com steps (1-dados 2-pagamento 3-confirmação)
  - Config repasse taxa: sem/percentual/fixo/percentual+fixo em `site_settings`, exibido claramente na linha "Taxa de serviço"
  - `Checkout\CheckoutService` orquestra: validar carrinho, aplicar snapshot, criar Order + OrderItems, criar Payment, delegar ao Gateway, retornar redirect ou dados para processamento client-side
  - Snapshot OrderItem: `product_name`, `size_name`, `quality_name`, `unit_price`, `discount_amount`, `promotion_id`, `bonus_amount`, `tax_amount`, `final_total`
- **Acceptance Criteria Addressed**: AC-8, AC-10, AC-11
- **Test Requirements**:
  - `rule` TR-11.1: Checkout fluxo completo (dados + pagamento) cria linha em `orders` e `order_items` com snapshot; após isso, atualizar preço da foto no banco NÃO altera `order_items.unit_price`; Evidence: SQL before/after
  - `rule` TR-11.2: Repasse taxa "percentual 5%" em pedido R$ 100 → `orders.tax_amount = 5.00`; exibido em checkout e página de sucesso; Evidence: tela + banco
  - `rubric` TR-11.3: Usabilidade checkout em mobile; scale 1-5; anchors 1=campos horizontais quebrados 3=aceitável mas ruim 5=coluna única, tamanhos touch, botões grandes, sem overflow; threshold >= 4; Evidence: screenshot 320px
- **Notes**: PaymentGateway será implementado em Task 12 — aqui criar StubGateway em `Payment\Gateways\` para testes.

---

## Task 12: Mercado Pago Real (Pix QR, Copia e Cola, Cartão Tokenizado) + Webhook Idempotente
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 11
- **Description**:
  - `MercadoPagoGateway implements PaymentGatewayInterface` usando SDK oficial atual
  - Pix: criar preferência PIX, retornar qr_code_base64 e qr_code (copia e cola), exibir contador regressivo de expiração em checkout (JS)
  - Cartão: SDK client-side gera token de cartão, NUNCA envia número/CVV para backend; envia apenas token + parcelas
  - Configurações `payment_gateways` tabela (id=1 mp, active, creds encrypted, env, methods, fees, webhook_token)
  - Rota webhook protegida por token: `POST /api/webhooks/mercadopago/{webhook_token}` — valida assinatura, insere linha em `payment_webhooks` com chave de idempotência (event_id MP ou x-idempotency-key)
  - Webhook listener: `Payment\Webhooks\MercadoPagoWebhookHandler` processa approved → atualiza Payment=paid, Order=available, dispara evento `OrderWasPaid` → listener libera fotos + envia email template "pagamento aprovado"
- **Acceptance Criteria Addressed**: AC-8, AC-9, AC-24
- **Test Requirements**:
  - `rule` TR-12.1: Criar charge via Pix retorna base64 QR e copia e cola; Payment.status=awaiting_payment; Evidence: JSON response + linha bd
  - `rule` TR-12.2: Disparar webhook `approved` 3 vezes com mesmo ID → `payment_webhooks` contém 3 linhas sendo 1 `processed=true` + 2 `skipped_idempotency=true`; `payment_transactions` não duplica; `orders.status` = available UMA vez; Evidence: `select * from payment_webhooks` e `select count(*) from payment_transactions` = 1
  - `rule` TR-12.3: Request webhook com token errado → 403; sem assinatura correta → 403; Evidence: HTTP 403
  - `rule` TR-12.4: `grep -r "card_number\|cvv" database/migrations app/Http/Controllers app/Services/Payment` (exceto comentários) retorna 0; Evidence: saída grep
- **Notes**: Adicionar comando `photo-commerce:expire-payments` para marcar Pix vencidos como expired.

---

## Task 13: Pedidos, Estornos (Total/Parcial), Refunds
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 12
- **Description**:
  - Admin Orders listagem (filtros por status/data/cliente), detalhe Order com itens + histórico
  - Admin Refund: botão estornar parcial (selecionar itens + valores) ou total via SweetAlert2 confirmação
  - `Refund\RefundService` cria `refunds/refund_items`, atualiza OrderStatus para partially_refunded ou refunded, chama `PaymentGatewayInterface::refundCharge`, dispara emails via templates
  - NUNCA deleta Orders/Items (soft delete permitido em casos mas preferir só status)
  - Exibir histórico completo de eventos em Order Detail (auditoria)
- **Acceptance Criteria Addressed**: AC-12, AC-10
- **Test Requirements**:
  - `rule` TR-13.1: Pedido pago de 3 itens; estornar item 1 parcial (R$ 10) → `refunds` 1 registro, `refund_items` 1 linha, `orders.status=partially_refunded`; estornar total → status `refunded`; deletar pedido retorna proibido ou não implementado; Evidence: estados do bd
  - `rule` TR-13.2: Ação estorno exige SweetAlert2 confirmação "Ação irreversível"; Evidence: screenshot modal
  - `rule` TR-13.3: `orders`, `order_items`, `payments` tabelas NÃO sofrem DELETE após fluxo completo (apenas update status); `grep "DB::table.*orders.*delete\|->delete()" app/Http/Controllers/OrderController.php` = 0; Evidence: grep negativo
- **Notes**: Implementar idempotência de estorno com coluna `idempotency_key` em refunds.

---

## Task 14: Painel do Cliente (/minha-conta) + Download Seguro Individual/ZIP
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 13
- **Description**:
  - Layout cliente separado: `resources/views/customer/layouts/app.blade.php` (Bootstrap 5, não AdminLTE)
  - Menu: Dashboard, Perfil, Pedidos, Compras, Fotos, Downloads, Pagamentos, Estornos, Reclamações, Tickets, Segurança
  - Rotas de download: `GET /minha-conta/downloads/{itemId}` (individual) e `GET /minha-conta/pedidos/{orderId}/zip` (ZIP assíncrono ou Job)
  - `Photo\DownloadAuthorizationService` valida: usuário autenticado é dono, pedido está available, item pertence ao pedido, janela de validade OK; salva log em `download_logs` (user, arquivo, pedido, IP, data)
  - Arquivo original servido via StreamResponse ou signed URL temporária; NUNCA link direto público
- **Acceptance Criteria Addressed**: AC-11, AC-13, AC-24
- **Test Requirements**:
  - `rule` TR-14.1: Logado como cliente A acessa `/minha-conta/downloads/{itemId_do_cliente_B}` → 403; cliente A no item correto → download inicia com 200 streaming + grava log; Evidence: 2 HTTP responses + log
  - `rule` TR-14.2: `storage/app/photos_private` NÃO tem `php artisan storage:link` público; não existe rota `/storage/photos_private/...`; tentativa URL direta do original retorna 404; Evidence: ls storage link + 404 via curl
  - `rubric` TR-14.3: UI dashboard cliente responsiva; scale 1-5; anchors 1=desktop-only 3=tablet ok 5=mobile otimizado cards, scroll horizontal nenhum; threshold >= 4; Evidence: 320px screenshot
- **Notes**: ZIP grande pode ser Job + notificação quando pronto.

---

## Task 15: Tickets e Reclamações (Cliente/Admin)
- **Status**: `pending`
- **Priority**: medium
- **Depends On**: Task 14
- **Description**:
  - Cliente: `/minha-conta/tickets` criar, listar, responder, anexar arquivos, vincular pedido
  - Admin: `/admin/tickets` listar, atribuir, mudar status (Aberto/Em atendimento/Aguardando cliente/Resolvido/Fechado), responder com Summernote
  - Reclamações vinculadas a pedido/foto/pagamento/download/suporte, com histórico
  - Disparar e-mails "ticket criado" / "resposta ticket" via templates + Jobs
- **Acceptance Criteria Addressed**: AC-13, AC-16
- **Test Requirements**:
  - `rule` TR-15.1: Cliente cria ticket anexando PNG, vinculado a pedido existente → grava em `tickets` + `ticket_messages` + `ticket_attachments`; resposta do admin dispara Job email; Evidence: linhas bd + failed_jobs vazio
  - `rule` TR-15.2: Tentar POST `/admin/tickets/{id}/status` sem `tickets.manage` → 403; Evidence: response
- **Notes**: Implementar contador de tickets abertos no dashboard admin e cliente.

---

## Task 16: Configurações do Site (Aparência, Seções, Tema CSS Vars), Banners, Frontend Público
- **Status**: `pending`
- **Priority**: medium
- **Depends On**: Task 15
- **Description**:
  - Tela `admin/settings/site` abas: Geral, Identidade Visual (logo, favicon, cores), Login/Foto, Banners, Slides, Rodapé
  - Salvar cores em `site_settings` e injetar dinamicamente em `<style>` inline via view composer com `:root { --primary: #xx; --secondary: #yy; ... }`
  - CRUD `site_banners` e `site_slides` (imagem + link + texto Summernote + período + desktop/mobile)
  - Controle de seções (habilitar/ordenar Hero, Álbuns, Promoções, Destaques, Depoimentos, CTA, Newsletter, Rodapé) em `site_sections`
  - Criar layout público `resources/views/storefront/layouts/app.blade.php` com navbar, seções configuráveis, rodapé, scrollbar custom CSS vars
- **Acceptance Criteria Addressed**: AC-23, AC-2, AC-26
- **Test Requirements**:
  - `rule` TR-16.1: Alterar `--primary` no painel para vermelho → reabrir home renderiza botões na cor vermelha; Evidence: 2 screenshots
  - `rule` TR-16.2: Desativar seção "Promoções" em controle → home NÃO renderiza `<section class="promotions">`; Evidence: HTML fonte
  - `rubric` TR-16.3: Frontend público profissional; scale 1-5; anchors 1=esqueleto 3=mediano 5=design coeso, imagens placeholders contextualizadas de alta qualidade via text_to_image, hierarquia clara, tipografia boa; threshold >= 4; Evidence: homepage screenshot
- **Notes**: Usar serviço text_to_image para banners/placeholders quando aplicável.

---

## Task 17: SEO Global/Por Página, Keywords Tag UI, Sitemap Dinâmico
- **Status**: `pending`
- **Priority**: medium
- **Depends On**: Task 16
- **Description**:
  - Tabelas `seo_settings` (global: title, description, keywords, favicon, robots, canonical, og:, twitter:, schema, imagem) e `seo_pages` (por página/álbum/foto)
  - Keywords UI: input text com comportamento "Enter transforma em chip [fotógrafo casamento ×]"; salva 1 keyword por linha em `seo_keywords`; duplicação bloqueada (unique)
  - Controlador `SitemapController` + `/sitemap.xml` que gera XML apenas de rotas públicas (álbuns publicados, fotos públicas, home, páginas estáticas). NUNCA inclui admin, login, minha-conta, checkout, downloads, tickets.
  - Injetar meta tags OG/Twitter/title/description/canonical em todas views públicas via middleware ou composer.
- **Acceptance Criteria Addressed**: AC-19, AC-24
- **Test Requirements**:
  - `rule` TR-17.1: GET `/sitemap.xml` Content-Type application/xml; validado com validador XSD simples; contém home + álbuns públicos; NÃO contém strings `/admin`, `/login`, `/minha-conta`, `/checkout`, `/downloads`, `/tickets`; Evidence: XML fonte
  - `rule` TR-17.2: UI keywords: enviar "fotógrafo casamento{Enter}eventos{Enter}fotógrafo casamento{Enter}" → salva apenas 2 keywords distintas; Evidence: SQL count = 2
  - `rule` TR-17.3: Álbum público tem `<meta property="og:title">`, `<meta name="twitter:card">`, `<link rel="canonical">`; Evidence: HTML fonte
- **Notes**: Schema.org JSON-LD para fotógrafo e álbuns.

---

## Task 18: Visitantes, Sessões, Origem UTM, Analytics Dashboard
- **Status**: `pending`
- **Priority**: medium
- **Depends On**: Task 17
- **Description**:
  - Middleware `VisitorTrackerMiddleware` em rotas públicas: grava `visitor_sessions` (session, device, browser, OS, referer, UTM* todo o conjunto) + `visitors` (página, álbum, foto, data)
  - `traffic_sources` classifica a origem: Google/Instagram/Facebook/WhatsApp/Direto/Referência/Outros via regras UTM e referer
  - Dashboard AdminLTE 4: widgets visitas/visitantes/visualizações/carrinhos/checkouts/compras/conversão %, origem gráfico, top álbuns, período
  - Respeitar LGPD: opção "Não rastrear" se DoNotTrack header ou cookie consent
- **Acceptance Criteria Addressed**: AC-20, AC-17
- **Test Requirements**:
  - `rule` TR-18.1: Acessar `/?utm_source=google&utm_medium=cpc&utm_campaign=casamento` → `traffic_sources.source = 'Google'` e `visitor_sessions.utm_source = google`; Evidence: linhas bd
  - `rule` TR-18.2: Acessar via referer=https://instagram.com → classificado como Instagram; Evidence: banco
  - `rule` TR-18.3: Dashboard widget "Conversão %" = (compras / visitas) * 100, calculado corretamente via SQL; comparação consulta SQL direta vs widget idêntica; Evidence: side a side
- **Notes**: Dashboard analytics integrado no mesmo layout do AdminLTE Task 5.

---

## Task 19: Promoções (Popup, Banner Flutuante, Barra, Carrossel, Modal) e Cupons
- **Status**: `pending`
- **Priority**: medium
- **Depends On**: Task 18
- **Description**:
  - CRUD `promotions` tipo: popup, banner flutuante, barra topo, carrossel, modal, banner de álbum. Campos: title, body_html (Summernote), image, album_id, starts_at, expires_at, is_active, positions, desktop_only/mobile_only
  - Cupons: tabela `coupons` código, tipo fixo/%, valor, mínimo, data validade, usos
  - `PromotionService` decide em runtime quais promoções exibir em cada view
  - UI frontend: barra topo, popup com atraso de X segundos configurável, carrossel bootstrap
- **Acceptance Criteria Addressed**: AC-26 (regras banners)
- **Test Requirements**:
  - `rule` TR-19.1: Criar promoção "Barra Topo" ativa hoje → home renderiza `<div class="promo-bar">`; expirar data → barra desaparece; Evidence: antes/depois
  - `rule` TR-19.2: Cupom BEMVINDO10 (%10) no checkout reduz total em 10%, usado 1 vez incrementa `coupons.used`; Evidence: total antes/depois + bd
- **Notes**: Não exibir popup repetidamente (cookie/session).

---

## Task 20: Queue (Database/Sync), Jobs (Email, ZIP, Processar Imagens), Central de Cron
- **Status**: `pending`
- **Priority**: medium
- **Depends On**: Task 19
- **Description**:
  - Configurar `.env QUEUE_CONNECTION=database` default; garantir `sync` sempre fallback
  - Jobs já criados anteriormente: `SendTestEmailJob`, `SendOrderEmailJob`, `ProcessImageJob`, `GenerateOrderZipJob` — agora garantir retry/backoff e failed_jobs
  - Console Kernel: agendar comandos Task 12 (expire-payments) + criar novos comandos `photo-commerce:cleanup`, `photo-commerce:process-emails`, `photo-commerce:process-images`, `photo-commerce:generate-analytics`
  - AdminLTE `/admin/sistema/cron` listar tarefas com última/próxima execução (gravar `cron_logs` quando executam)
  - README adicionar linha cron cPanel e instrução queue:work via `queue:listen` cron ou daemon cPanel (supervisord opcional)
- **Acceptance Criteria Addressed**: AC-18
- **Test Requirements**:
  - `rule` TR-20.1: `php artisan list` contém os 5 comandos photo-commerce; rodar `php artisan photo-commerce:expire-payments` em Pix vencido → marca Payment=expired e grava `cron_logs`; Evidence: saída + bd
  - `rule` TR-20.2: Tela Central de Cron exibe no mínimo 5 tarefas com frequência e status; Evidence: screenshot
- **Notes**: `php artisan queue:failed` deve listar falhas; UI ver falhas opcional.

---

## Task 21: Testes Automatizados Essenciais (Pest ou PHPUnit)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 20
- **Description**:
  - Testes Feature (Pest plugin Laravel ou PHPUnit):
    1. Login/logout/forgot password
    2. Permissões RBAC (3 rotas admin sem permissão → 403)
    3. CRUD Álbum (super admin)
    4. Upload de foto (store + processamento)
    5. Cálculo preço/desconto/bônus
    6. Cart adulterado → mesmo total
    7. Checkout cria order snapshot
    8. Webhook idempotência (3x approved)
    9. Download autorizado vs não autorizado
    10. Estorno parcial e total → pedido não deletado
    11. SMTP teste falha sem expor credencial
    12. Cron expire-payments
  - Garantir `php artisan test` exit 0
- **Acceptance Criteria Addressed**: AC-21, AC-1, AC-7, AC-9, AC-11, AC-12, AC-15, AC-18
- **Test Requirements**:
  - `rule` TR-21.1: Executar `php artisan test --parallel` (sem paralelo se não suportado) → todos testes PASS, 0 failures, 0 errors; número de testes >= 25; Evidence: saída completa
  - `rule` TR-21.2: Teste "webhook idempotência" realiza 3 posts idênticos e assert count(PaymentTransaction) === 1; Evidence: código teste
- **Notes**: Usar RefreshDatabase + factories (criar factories User, Album, Photo, Order, Payment).

---

## Task 22: Auditoria, Segurança Fina, Logs, Performance (Cache, Lazy, WebP, Índices)
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 21
- **Description**:
  - `AuditLogObserver` para modelos: created/updated/deleted, grava user/action/entity/id/ip/user_agent/old_values/new_values exceto senhas/secrets/cvv
  - Middleware headers: X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy; sessão secure/httponly/same_site
  - Performance: eager loading em queries N+1 (álbuns→fotos, orders→items etc.), cache (tags quando driver=array não, então file/database) para listas públicas, lazy loading nativo em imagens, conversão automática WebP via Intervention quando disponível, paginação 15/20 em todas listagens
  - Verificar e adicionar índices FK + queries frequentes
- **Acceptance Criteria Addressed**: AC-24, AC-22 (qualidade arquitetura)
- **Test Requirements**:
  - `rule` TR-22.1: Update Album título com Super Admin logado → `audit_logs` insere linha correta com old_value e new_value; colunas `password`, `smtp_password`, `cvv` NUNCA aparecem em `audit_logs.old_values/new_values` (busca negativa após update em User/Payment); Evidence: SQL + grep
  - `rule` TR-22.2: Response headers de home contêm X-Frame-Options SAMEORIGIN/DENY, X-Content-Type-Options nosniff; cookies session com httponly; Evidence: DevTools Network
  - `rubric` TR-22.3: Performance e qualidade; scale 1-5; anchors 1=N+1 queries em dashboard 3=algumas otimizações 5=eager loading + indexes em FKs + lazy + paginação + cache; threshold >= 4; Evidence: DebugBar ou clockwork mostrando <= N queries esperadas por página
- **Notes**: Laravel DebugBar apenas local (APP_DEBUG).

---

## Task 23: Integração Final, Responsividade, README Completo, Documentação Deploy cPanel
- **Status**: `pending`
- **Priority**: high
- **Depends On**: Task 22
- **Description**:
  - Rodar `php artisan migrate:fresh --seed`, criar Super Admin por comando (`photo-commerce:create-admin` ou `db:seed UserSeeder`), verificar todas rotas listadas
  - Testar fluxo completo: Home → Álbum público → Galeria → Foto → Tamanho/Preço → Carrinho (desconto/bônus) → Checkout (Pix MP teste sandbox se possível ou StubGateway) → Webhook aprovação manual → Pagamento Aprovado → E-mail → Minha Conta → Download Individual/ZIP; gravar evidências em screenshots e logs
  - Escrever README.md completo em português: Requisitos, Instalação, Banco, Configuração, SMTP, Mercado Pago, Google Drive, Cron, Queue, cPanel passo-a-passo (11 seções: criar banco → .env → Composer → migrate → storage link → permissões → cron → queue → domínio → SSL → produção), testes, troubleshooting, segurança
  - Adicionar atribuição de autoria nos arquivos PHP principais quando apropriado (DocBlock @autor Marcelo Brad RJ)
  - Verificar responsividade 320/768/1280, acessibilidade básica (alt em imagens, labels em inputs)
- **Acceptance Criteria Addressed**: AC-25, AC-23, AC-26, AC-17 (integração)
- **Test Requirements**:
  - `rule` TR-23.1: Fluxo completo home→download roda do começo ao fim sem exceptions (logs laravel empty exceto info); Evidence: lista de telas percorridas (screenshots) + `storage/logs/laravel.log` grep "ERROR" = 0
  - `rule` TR-23.2: README.md contém 11 seções de deploy cPanel com linha de cron correta + estrutura `/home/usuario/app/Laravel` + `/home/usuario/public_html`; `.gitignore` inclui `.env`; Evidence: diff/readme
  - `rubric` TR-23.3: Cumprimento checklist 34 regras absolutas #77 espec original; scale 1-5; anchors 1=mais de 8 violações 3=2-5 violações leves 5=0 violações graves; threshold >= 5 (ou seja, 0 violações graves); Evidence: checklist próprio anexado às evidências de conclusão
- **Notes**: Incluir `commands/CreateSuperAdmin.php` para criação rápida do primeiro admin.

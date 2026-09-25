# Photo Commerce System - Product Requirements Document

## Overview
- **Summary**: Sistema profissional completo e desacoplado para venda online de fotografias de UM ÚNICO FOTÓGRAFO, construído com Laravel + PHP 8.4+, AdminLTE 4 no painel administrativo, Summernote como editor WYSIWYG, e integração real com Mercado Pago e Google Drive (opcional).
- **Purpose**: Permitir que um fotógrafo independente venda suas fotografias (eventos, casamentos, festas, formaturas, esportes, shows, ensaios etc.) online, com checkout transparente, proteção de originais, controle de descontos progressivos, bônus/brindes, estornos, tickets, analytics de visitas, SEO completo e painel administrativo profissional.
- **Target Users**:
  - **Administrador**: Fotógrafo proprietário e usuários administrativos auxiliares com permissões granulares (RBAC).
  - **Clientes**: Usuários finais que compram e baixam fotografias.

## Goals
- Entregar um sistema Laravel profissional, completo, desacoplado (Services/Repositories/DTOs/Actions/Contracts), responsivo, seguro e pronto para hospedagem compartilhada cPanel/WHM/CloudLinux/LiteSpeed.
- Implementar painel administrativo 100% baseado em AdminLTE 4 (sidebar, navbar, dashboard, widgets, cards, tables, forms, tabs, modals, pagination, dark mode etc.).
- Editor WYSIWYG Summernote em todos os campos ricos, com componente Blade reutilizável.
- Integração real de pagamento via Mercado Pago (Pix + Cartão transparente) com webhook idempotente.
- Storage desacoplado (local obrigatório + Google Drive opcional) com proteção absoluta das fotos originais (storage privado, autorização obrigatória no download).
- Carrinho, checkout transparente, desconto progressivo configurável, bônus/brindes, promoções/banners/popups.
- Painel do cliente (/minha-conta) com pedidos, downloads, estornos, tickets, reclamações.
- RBAC completo (roles, permissions, Policies, Gates).
- SEO global e por página, sitemap dinâmico, analytics de visitas/UTM/origem.
- SMTP configurável via painel com envio de teste, central completa de templates de e-mail.
- Central de Cron do Laravel Scheduler com tarefas próprias, Queue com driver database/sync (sem Redis obrigatório).
- Testes automatizados para funcionalidades essenciais.
- 100% compatível com PHP 8.4+, MySQL/MariaDB, Composer, cPanel/WHM, CloudLinux, LiteSpeed, Apache.

## Non-Goals
- **NÃO** implementar arquitetura multi-tenant ou marketplace.
- **NÃO** cadastrar múltiplos fotógrafos nem cobrar por fotógrafo.
- **NÃO** usar React, Vue, Angular, Next.js ou frameworks frontend como requisito estrutural (apenas Blade + Bootstrap 5 + JavaScript modular).
- **NÃO** exigir Docker, Node.js permanente, Redis obrigatório ou serviços externos obrigatórios para o core funcionar.
- **NÃO** criar dados fictícios (falsas vendas, falsos pedidos, falsas métricas) em seeders; apenas roles, permissões, templates e configurações padrão.
- **NÃO** colocar `.env` ou arquivos sensíveis dentro de `public_html`.
- **NÃO** expor originais de fotos diretamente via URL pública.
- **NÃO** utilizar `alert()`, `confirm()` ou `prompt()` nativos do navegador.

## Background & Context
- Especificação completa fornecida em `markdown` pelo usuário contendo 78 seções detalhadas (stack obrigatória, arquitetura, fluxos, regras absolutas).
- Diretório do projeto atualmente vazio (`c:\Users\marce\OneDrive\Desktop\PROJETOS WEB\SITE FOTOGRAFOS`), portanto o Laravel será criado do zero.
- Autor do projeto: Marcelo Brad RJ (contato: 21 981325441 / contato@kdkhost.com.br / Telegram: @MARCELO_BRAD / Instagram: @marcelobradrj / WhatsApp: 21981325441), com atribuição de autoria nos arquivos PHP principais quando apropriado.

## Functional Requirements

### FR-1: Stack e Projeto Laravel Base
- Criar projeto Laravel versão estável compatível com PHP 8.4+ via Composer.
- Configurar `.env.example` completo (APP_KEY, DB, MAIL, Mercado Pago, Google Drive, Queue, Storage, Analytics).
- Estrutura de diretórios desacoplada: `app/Actions, app/Contracts, app/DTOs, app/Enums, app/Exceptions, app/Http/{Controllers,Middleware,Requests}, app/Jobs, app/Listeners, app/Mail, app/Models, app/Notifications, app/Policies, app/Repositories, app/Services/{Album,Cart,Checkout,Discount,Email,Photo,Promotion,Refund,Seo,Storage,Visitor,Payment/{Contracts,Gateways,Webhooks}}, app/Support`.
- Blade + Bootstrap 5 no frontend público e AdminLTE 4 exclusivamente no painel administrativo.
- JS modular em `resources/js/{app,notifications,sweetalert,uploader,sortable,cart,checkout,payments,admin/*,customer/*}`.
- CSS organizado em `resources/css/{app,admin,storefront,login,checkout,components/*}` com CSS variables (--primary, --secondary etc.).

### FR-2: AdminLTE 4 Painel Administrativo
- Estrutura 100% oficial: Layout, Sidebar, Navbar, Breadcrumb, Content, Cards, Widgets, Tables (responsive), Forms, Input groups, Validation states, Tabs, Accordion, Modals, Dropdowns, Buttons, Badges, Alerts, Progress bars, Tooltips, Popovers, Pagination, Search, Filters, Empty states, Loading states, Dark mode (quando suportado), Responsive layout.
- Dashboard AdminLTE 4 com dados reais: faturamento, pedidos, clientes, fotos vendidas, álbuns publicados, visitas, conversão, pagamentos pendentes/aprovados, estornos, tickets, downloads + filtros (hoje/ontem/7d/30d/mês atual/mês anterior/período personalizado).

### FR-3: Summernote WYSIWYG Obrigatório
- Componente Blade reutilizável: `resources/views/components/forms/summernote.blade.php`.
- Configurado com toolbar, upload de imagens, altura, fullscreen, código HTML, limpeza de formatação, tabelas, links, vídeos.
- Aplicado em: descrição de álbum/foto, textos institucionais, páginas, banners, promoções, termos, política de privacidade, mensagens, templates de e-mail, SEO rico, conteúdo home/rodapé, tickets, configurações de conteúdo.
- Funciona dentro de modals, tabs e formulários do AdminLTE 4.

### FR-4: Usuários, Autenticação e Segurança
- Login/Logout/Recuperação/Redefinição de senha/Verificação de e-mail/Lembrar-me/Rate limiting/Proteção brute force/Sessões seguras/CSRF/Session fixation.
- Tela de login desktop 2 colunas (esquerda: foto configurável ocupando 100% como background com overlay; direita: formulário). Mobile: apenas formulário, sem espaço reservado.
- Tipos de usuário: Administrador (fotógrafo/proprietário), Usuários administrativos auxiliares (RBAC), Clientes.
- Segurança: CSRF, XSS, SQL Injection (Eloquent), IDOR (Policies/Gates), rate limiting, validação MIME upload, storage privado, signed URLs, sessão segura, cookies seguros, headers seguros, audit logs, idempotência, proteção de webhook.
- Tabela `audit_logs` (usuário, ação, entidade, ID, IP, User Agent, valores antigos/novos, data/hora) — NUNCA registrar senhas/CVV/secrets.

### FR-5: RBAC (Roles, Permissions, Policies, Gates)
- Tabelas: `roles, permissions, role_permissions, user_roles`.
- Permissões granulares: `albums.{view,create,update,delete}`, `photos.{view,create,update,delete}`, `orders.{view,update}`, `payments.{view,manage}`, `refunds.{view,create,approve}`, `promotions.{view,create,update,delete}`, `customers.{view,manage}`, `tickets.{view,manage}`, `settings.{view,update}`, `seo.{view,update}`, `storage.manage`, `smtp.manage`, `email_templates.manage`, `users.manage`, `roles.manage`, `permissions.manage`, `audit_logs.view`.
- Gates e Policies registrados e aplicados em todos os Controllers.

### FR-6: Álbuns, Fotos e Upload Drag & Drop
- CRUD completo de Álbuns: título, slug, descrição Summernote, evento, capa, data, local, status (rascunho/publicado/privado/arquivado/encerrado), visibilidade, senha opcional, início/encerramento, SEO.
- Upload drag & drop profissional com SortableJS: múltiplos arquivos, preview, progresso, retry, cancelamento, validação, ordenação, AJAX, processamento, thumbnail, marca d'água.
- Cada foto: título, código, descrição Summernote, original/preview/thumbnail/watermarked/purchased, categoria, álbum, ordem, status, preço, qualidade, tamanho, metadados, SEO.
- Tamanhos/qualidades configuráveis (Standard/HD/Full HD/Premium/Original) com preço próprio.
- Dimensões recomendadas/minimas (Banner Desktop 1920x650, Mobile 768x900, Capa 1200x800, OG 1200x630, Avatar 400x400) centralizadas.

### FR-7: Carrinho, Desconto Progressivo, Bônus, Promoções
- Carrinho com uma/várias fotos, quantidades, tamanhos/qualidades, atualização AJAX, subtotal/desconto/bônus/taxa/total. NUNCA confiar em preços vindos do frontend.
- Desconto progressivo configurável (ex.: 1=0%, 3=5%, 5=10%, 10=20%, 20=30%), ativar/desativar, faixas, % por álbum/global, prioridade, impedir acúmulo.
- Bônus/brindes: "compre X ganhe Y", por qualidade/quantidade/valor/tamanho. Admin seleciona fotos elegíveis a brinde.
- Promoções: popup, banner flutuante, barra, carrossel, modal, banner no álbum — texto Summernote, imagem, período, ativação, posição, desktop/mobile.

### FR-8: Checkout Transparente, Mercado Pago, Webhook
- Checkout transparente (não envia cliente para site externo quando o gateway suportar). Campos: nome, e-mail, telefone, CPF, endereço (quando necessário), pagamento.
- `PaymentGatewayInterface` + `MercadoPagoGateway` suportando Pix, Cartão, consulta, criação, cancelamento, estorno, webhook, idempotência, logs, erros. Usar APIs oficiais atuais. NUNCA armazenar dados de cartão.
- Arquitetura para múltiplos gateways (Mercado Pago, EFI, PagHiper, PaySeguro, outros) com adapters independentes. Painel: Gateway, Ativo, Credenciais, Ambiente, Métodos, Taxas, Webhook, Testar conexão.
- Pix: ativo/inativo, validade/expiração, QR Code, copia e cola, consulta, webhook + contador de expiração no checkout. Após expirar marcar como expirado e permitir nova tentativa.
- Cartão: tokenização/SDK oficial, parcelas conforme suporte do gateway.
- Repasse de taxa configurável (sem/percentual/fixo/percentual+fixo) exibido claramente no checkout.
- Webhook próprio: `/api/webhooks/mercadopago/{token}` com validação, identificação de pedido, idempotência, payload, atualização, pagamento, pedido, liberação, e-mail, auditoria. NÃO processar mesmo webhook 2x.

### FR-9: Pedidos, Pagamentos, Estornos, Snapshot
- Pedido: Order Status separado de Payment Status. Status: pending, awaiting_payment, paid, processing, available, partially_refunded, refunded, cancelled, expired, failed.
- Snapshot monetário no pedido: nome produto, tamanho, qualidade, preço, desconto, promoção, bônus, taxa, valor final (usar DECIMAL(12,2) nunca FLOAT).
- Estorno total e parcial (por item): solicitação do cliente, aprovação, recusa, motivo, histórico. NUNCA apagar pedido.
- Idempotência em pagamento, webhook, pedido, estorno.

### FR-10: Painel do Cliente, Download Seguro, Tickets, Reclamações
- `/minha-conta` com menu: Dashboard, Perfil, Pedidos, Compras, Fotos, Downloads, Pagamentos, Estornos, Reclamações, Tickets, Segurança.
- Download seguro: individual/ZIP, validação de autorização (cliente/pedido/pagamento/item/validade). Registrar cliente, arquivo, pedido, data, IP.
- Tickets: cliente abre/responde/anexa/relaciona pedido; admin responde/atribui/altera status/fecha. Status: Aberto/Em atendimento/Aguardando cliente/Resolvido/Fechado.
- Reclamações vinculadas a pedido/foto/pagamento/download/suporte, com histórico.

### FR-11: Storage, Google Drive Opcional, Proteção de Originais
- `StorageDriverInterface` com `LocalStorageDriver` e `GoogleDriveStorageDriver`. Permitir escolher Servidor/Google Drive.
- Separação estrita: original, preview, thumbnail, watermarked, purchased. Originais permanecem em storage privado. Download passa por autorização obrigatória.
- Google Drive: autenticação, conexão, pasta principal, teste, sincronização, status, logs. Ausência não impede armazenamento local.

### FR-12: SMTP, Central de E-mail, Templates
- Administração → Configurações → SMTP: host, porta, usuário, senha (não exibir salva), criptografia TLS/SSL, remetente, nome remetente, reply-to, timeout.
- Botão "Enviar e-mail de teste" com destinatário + Notify/Toast sucesso/falha + logs sem expor credenciais.
- Central de Templates de e-mail (Administração → E-mails → Templates): recuperação senha, confirmação cadastro, verificação e-mail, pedido criado, pagamento pendente, Pix gerado, pagamento aprovado/recusado/expirado, pedido cancelado, fotos liberadas, download disponível, estorno solicitado/aprovado/recusado, ticket criado/resposta, promoção, contato, alteração senha/e-mail, alerta administrativo, teste SMTP.
- Cada template: nome, assunto, HTML (Summernote), texto, ativo/inativo, variáveis, preview, envio teste. NUNCA escrever HTML de e-mail diretamente em Controllers; usar Jobs quando apropriado.

### FR-13: Cron, Queue, Central de Cron
- Laravel Scheduler com comandos: `photo-commerce:expire-payments`, `photo-commerce:cleanup`, `photo-commerce:process-emails`, `photo-commerce:process-images`, `photo-commerce:generate-analytics`.
- Administração → Sistema → Cron exibindo tarefa, descrição, frequência, última/próxima execução, duração, status, último erro. Instrução compatível com cPanel.
- Queue com driver database/sync (sem Redis obrigatório). Jobs: e-mails, processamento de imagens, ZIP, sincronização, tarefas pesadas. Tabela `failed_jobs`.

### FR-14: SEO, Keywords, Sitemap
- SEO global e por página: title, description, keywords, favicon, robots, canonical, Open Graph, Twitter Card, imagem, Schema.org, sitemap.
- SEO por página: SEO title, meta description, keywords, slug, canonical, robots, imagem.
- Keywords: tags com Enter, duplicação bloqueada, cada palavra salva individualmente.
- Sitemap dinâmico apenas com páginas públicas/indexáveis (NUNCA admin, login, checkout privado, pedidos, downloads, tickets).

### FR-15: Visitas, Origem, UTM
- Registrar: sessão, página, álbum, foto, origem, referer, UTM (source/medium/campaign/term/content), dispositivo, navegador, SO, data/hora.
- Dashboard: visitas, visitantes, visualizações, carrinhos, checkouts, compras, conversão. Boas práticas LGPD.
- Origem exibida como: Google, Instagram, Facebook, WhatsApp, Direto, Referência, Outros. Relacionar origem à compra quando possível.

### FR-16: Configurações do Site, Seções, Tema
- Administração → Configurações (AdminLTE 4) com abas: Geral, Identidade visual, SMTP, E-mails, Pagamentos, Mercado Pago, Pix, Cartão, Google Drive, Storage, Promoções, Descontos, Bônus, Downloads, SEO, Analytics, Segurança, Cron, Queue, LGPD, Usuários, Roles, Permissões.
- Site: logo, favicon, cores, tipografia, fundo, banners, slides, carrossel, menu, rodapé, login, recuperação senha.
- Controle de seções (ativar/desativar + ordenar): Hero, Álbuns, Promoções, Destaques, Depoimentos, CTA, Newsletter, Rodapé.
- Scrollbar personalizado via CSS variables (paleta configurada), sem quebrar acessibilidade.

### FR-17: Notificações e UI/UX
- NUNCA `alert()/confirm()/prompt()`. Usar Notify/Toast para notificações, SweetAlert2 para confirmações, exclusão, estorno, cancelamento e ações irreversíveis. Arquivo JS centralizado.
- Responsividade: AdminLTE 4 completo no desktop, adaptado no tablet, sidebar recolhível + tabelas responsivas + cards + forms adaptados + checkout otimizado no mobile. Login mobile somente formulário.

### FR-18: Banco, Performance, Testes, Seeders
- Migrations completas para todas as tabelas listadas (users, roles, permissions, role_permissions, user_roles, photographer_profile, albums, album_categories, photos, photo_sizes, photo_prices, photo_files, carts, cart_items, orders, order_items, payments, payment_transactions, payment_webhooks, payment_gateways, promotions, promotion_rules, promotion_bonuses, promotion_gifts, coupons, refunds, refund_items, tickets, ticket_messages, complaints, visitors, visitor_sessions, traffic_sources, seo_settings, seo_keywords, seo_pages, site_settings, site_sections, site_banners, site_slides, storage_settings, email_templates, email_logs, cron_logs, audit_logs, failed_jobs). Nenhuma estrutura multi-tenant.
- Performance: cache, lazy loading, thumbnails, WebP/AVIF quando apropriado, eager loading, indexes, paginação, filas. NUNCA carregar originais desnecessariamente.
- Testes: login, logout, recuperação, permissões, álbum, upload, preço, carrinho, desconto, bônus, promoção, checkout, pagamento, webhook, download, estorno, ticket, SMTP, e-mail, cron, segurança.
- Seeders: apenas roles, permissions, configurações padrão, templates de e-mail, estados necessários.

### FR-19: Deploy cPanel e Documentação
- README.md com requisitos, instalação, banco, configuração, SMTP, Mercado Pago, Google Drive, cron, queue, cPanel, produção, testes, troubleshooting, segurança.
- Preparado para PHP Selector, Composer, MySQL/MariaDB, Cron Jobs, Document Root, Storage, public_html, LiteSpeed, CloudLinux.
- Deploy cPanel: `/home/usuario/app/Laravel` + `/home/usuario/public_html` (Laravel public) com DocumentRoot correto e `.env` fora da área pública.
- Atribuição de autoria nos arquivos PHP principais quando apropriado.

### FR-20: API v1 Básica e LGPD
- `/api/v1/` com endpoints: auth, albums, photos, cart, orders, payments, webhooks, downloads. Documentar.
- Aplicar boas práticas LGPD em visitas e dados pessoais.

## Non-Functional Requirements
- **NFR-1 (Segurança)**: Toda rota sensível autenticada, Policies/Gates aplicadas, CSRF em todo POST/PUT/DELETE, signed URLs em download, validação estrita de upload/MIME, nenhuma credencial exposta em logs/respostas, idempotência em pagamento/webhook/estorno.
- **NFR-2 (Performance)**: Tempo de resposta dashboard inicial < 2s (cache aplicado), lazy loading em imagens, paginação >= 15 por página, não carregar originais em listagens públicas.
- **NFR-3 (Compatibilidade cPanel)**: Core funcionando sem Docker/Node/Redis; apenas Composer + PHP 8.4+ + MySQL/MariaDB + Cron.
- **NFR-4 (Desacoplamento)**: Nenhuma regra de negócio complexa em Controllers. Services/Repositories/DTOs/Actions/Contracts utilizados consistentemente.
- **NFR-5 (Qualidade de código)**: PSR-12, type hints, return types, classes pequenas, Forms Requests, Policies, Exceptions customizadas, duplicação mínima.
- **NFR-6 (Responsividade)**: Layout público e AdminLTE 4 funcionando corretamente em 320px (mobile), 768px (tablet), 1280px+ (desktop).
- **NFR-7 (Testabilidade)**: Testes essenciais cobrindo login, permissões, carrinho, checkout, pagamento/webhook, download, estorno.
- **NFR-8 (Observabilidade)**: Logs de auditoria, logs de e-mail, logs de cron, logs de pagamento/webhook, failed_jobs.
- **NFR-9 (Internacionalização/Conteúdo)**: Todas as telas, mensagens e conteúdos em português brasileiro (pt-BR).

## Constraints
- **Technical**: Laravel versão estável compatível com PHP 8.4+, PHP 8.4+, MySQL/MariaDB, Composer, Bootstrap 5, AdminLTE 4, Summernote, SweetAlert2, Notify/Toast, SortableJS, JavaScript ES6+, AJAX/fetch, Laravel Mail/Notifications/Scheduler/Queue/Storage, Mercado Pago (API oficial atual), Google Drive API, PHPUnit/Pest. Frontend apenas Blade + Bootstrap (sem React/Vue/Angular). Queue database/sync apenas.
- **Business**: Sistema para UM ÚNICO FOTÓGRAFO. NÃO multi-tenant, NÃO marketplace, NÃO múltiplos fotógrafos, NÃO cobrança por fotógrafo, NÃO isolamento de dados por fotógrafo. Admin representa fotógrafo proprietário.
- **Dependencies**: APIs oficiais atuais do Mercado Pago e Google Drive SDK; SweetAlert2 e Notify/Toast substituem alertas nativos; AdminLTE 4 como estrutura exclusiva do painel; Summernote obrigatório em todo campo rico.
- **Ambiente**: Projeto deve funcionar em hospedagem compartilhada (cPanel/WHM/CloudLinux/LiteSpeed/Apache). Sem Docker, sem Node.js permanente, sem Redis obrigatório, sem serviços externos obrigatórios para funcionamento do core.

## Assumptions
- Usuário final disponibilizará credenciais reais de Mercado Pago, Google Drive e SMTP em produção (.env); no ambiente de desenvolvimento serão utilizadas apenas variáveis de exemplo.
- Fotógrafo já possui domínio e hospedagem cPanel compatível com PHP 8.4+ e MySQL/MariaDB.
- Operações de pagamento real serão realizadas apenas em ambiente de produção com credenciais válidas.
- Originais de fotografias serão enviados pelo painel administrativo via upload drag & drop.

## Open Questions
- [ ] Há preferência específica de tema de cores inicial no AdminLTE 4 e no site público, além do configurável via painel?
- [ ] O padrão de RBAC inicial precisa apenas de 3 roles (Super Admin / Admin Assistente / Cliente) ou existem mais perfis?
- [ ] A API v1 exigirá autenticação via sanctum token ou session apenas?

---

## Acceptance Criteria

### AC-1: Projeto Laravel Base Criado e Configurado
- **Type**: `rule`
- **Given**: Diretório do projeto vazio e PHP 8.4+ / Composer instalados
- **When**: Rodar criação do projeto Laravel, configurar `.env.example`, criar estrutura desacoplada (Actions/Contracts/DTOs/Enums/Exceptions/Jobs/Listeners/Mail/Notifications/Policies/Repositories/Services/*/Support), organizar JS e CSS modular
- **Then**: `composer install` e `php artisan key:generate` executam sem erros; diretórios e arquivos da estrutura desacoplada existem; `php artisan --version` retorna versão compatível
- **Pass Condition**: `php artisan route:clear && php artisan config:clear` executam sem erros e estrutura de diretórios confere com a especificação
- **Evidence**: Saída de comandos `ls`/`tree` + saída `php artisan`; arquivos de configuração; `.env.example` completo

### AC-2: Painel AdminLTE 4 com Sidebar/Navbar/Dashboard/Breadcrumb/Cards/Tables/Forms/Modals/Tabs/Pagination
- **Type**: `rubric`
- **Dimension**: Fidelidade e completude da estrutura AdminLTE 4 no painel
- **Scale**: 1-5
- **Anchors**: 1 = CSS carregado mas estrutura manual própria; 3 = componentes oficiais mas faltam sidebar completa/breadcrumb/tabs/modals/tooltips; 5 = todos componentes oficiais do AdminLTE 4 (sidebar, navbar, breadcrumb, dashboard com widgets, cards, tables responsive, forms, tabs, accordion, modals, dropdowns, pagination, tooltips, popovers, dark mode quando suportado) seguindo padrão oficial e aparência consistente
- **Pass Threshold**: >= 4
- **Evidence**: Screenshots do painel, inspeção de layouts Blade em `resources/views/admin/*` e `resources/views/vendor/adminlte/*`

### AC-3: Summernote com Upload de Imagens em Todos Campos Ricos + Componente Reutilizável
- **Type**: `rule`
- **Given**: Painel administrativo acessível
- **When**: Abrir formulários de álbum (descrição), foto (descrição), templates de e-mail, páginas, promoções, banners, SEO, home, rodapé, tickets, configurações
- **Then**: Todos exibem o editor Summernote inicializado via componente Blade reutilizável (`x-forms.summernote`), com toolbar, upload de imagens, fullscreen, código HTML, limpeza de formatação, tabelas, links, e funciona dentro de modals e tabs
- **Pass Condition**: Componente `resources/views/components/forms/summernote.blade.php` existe; `grep -r "x-forms.summernote\|@include.*summernote" resources/views/admin` retorna uso em todos locais obrigatórios; console do browser sem erros JS
- **Evidence**: Arquivo do componente Blade + ocorrências de uso + screenshot de 3 campos ricos distintos

### AC-4: Login Responsivo 2 Colunas (Desktop) e Apenas Formulário (Mobile) + Recuperação
- **Type**: `rule`
- **Given**: Não autenticado
- **When**: Abrir `/login` em desktop (>=1024px) e em mobile (<=425px)
- **Then**: Desktop: coluna esquerda com foto background + overlay configurável + logo/nome/descrição; coluna direita formulário (email, senha, lembrar-me, Entrar, Esqueci). Mobile: coluna foto OCULTA completamente (nenhum espaço reservado); apenas formulário visível. `/forgot-password` e `/reset-password/{token}` funcionam com Laravel nativo e não revelam se e-mail existe
- **Pass Condition**: Visualização desktop exibe 2 colunas e mobile (devtools) apenas formulário; envio de formulário de recuperação SEMPRE retorna mesma mensagem independentemente de e-mail existir
- **Evidence**: Screenshots desktop e mobile + inspeção CSS (display:none na coluna foto no breakpoint mobile) + resposta HTTP de recuperação (status 200 sem variação)

### AC-5: RBAC Completo com Permissões Granulares + Policies/Gates em Operações Sensíveis
- **Type**: `rule`
- **Given**: Seeders executados (roles e permissions)
- **When**: Atribuir permissões `albums.create`, `albums.delete`, `payments.manage` etc. a diferentes usuários e tentar ações
- **Then**: Usuário sem `albums.delete` recebe 403 ao deletar álbum; usuário sem `payments.manage` não acessa gestão de pagamentos; Policies/Gates registrados; tabelas `roles/permissions/role_permissions/user_roles` populadas com permissões listadas na especificação
- **Pass Condition**: Tabela `permissions` contém todas permissões granulares definidas em FR-5; 3 ações de UI/rotas com permissão negada retornam 403 corretamente; `php artisan tinker` lista Policies registradas
- **Evidence**: `php artisan db:table permissions` (ou equivalente) + saída de tentativa 403 + `app/Providers/AuthServiceProvider.php`

### AC-6: Upload Drag & Drop + SortableJS + Processamento de Múltiplas Imagens
- **Type**: `rule`
- **Given**: Álbum existente e usuário com `photos.create`
- **When**: Arrastar 5 arquivos JPG/PNG para área de upload no álbum
- **Then**: Exibe preview individual, barra de progresso, pode cancelar/retry, após upload cria registros em `photos` com original/preview/thumbnail/watermarked corretamente armazenados; reordenar com SortableJS persiste `ordem`; dimensões e watermark aplicados
- **Pass Condition**: Banco contém 5 fotos ligadas ao álbum; storage contém arquivos nas 4 versões; ordem alterada persiste após refresh; MIME não-imagem é rejeitado
- **Evidence**: Inspeção tabela `photos`, estrutura de diretórios storage, screenshot do uploader com progresso visível

### AC-7: Carrinho + Desconto Progressivo + Bônus com Preços Nunca Confiáveis do Frontend
- **Type**: `rule`
- **Given**: 3 fotos com preço R$ 20,00 e desconto progressivo "3 fotos = 10%" e bônus "leve 3 ganhe 1"
- **When**: Adicionar 3 fotos no carrinho via UI e, em paralelo, tentar adulterar preço para R$ 0,01 via request manual
- **Then**: Carrinho exibe subtotal R$ 60,00, desconto 10% = R$ 54,00 + brinde elegível. Tentativa de adulteração de preço é IGNORADA (sistema recalcula tudo no backend). Adição/remoção/quantidade atualiza via AJAX sem recarregar página
- **Pass Condition**: `CartService` recalcula preços a partir de banco (não usa request `price`); resposta AJAX atualiza total; tentativa de preço adulterado resulta no mesmo total do cálculo limpo
- **Evidence**: Código de `CartService` (não aceita price externo) + saída de request adulterado vs limpo (total igual) + screenshot carrinho com desconto aplicado

### AC-8: Checkout Transparente Mercado Pago (Pix QR + Copia e Cola + Expiração) + Sem Armazenamento Cartão
- **Type**: `rule`
- **Given**: Gateway Mercado Pago ativado e credenciais configuradas (ambiente sandbox quando houver)
- **When**: Finalizar pedido escolhendo Pix e (em outro fluxo) Cartão
- **Then**: Pix: gera QR Code + copia e cola + contador de expiração visível; expiração marca `payment.status=expired` e permite nova tentativa. Cartão: usa tokenização/SDK oficial (NENHUM número completo/CVV enviado para backend nosso; apenas token do gateway). Nenhuma coluna em `payments`/`orders` armazena número de cartão ou CVV
- **Pass Condition**: Busca por `card_number`, `cvv`, `credit_card_number` em migrations retorna vazio; Pix exibe QR e expira (simulado com cron) marcando status
- **Evidence**: Código migrations (busca negativa) + `MercadoPagoGateway.php` usando tokenização + screenshot checkout Pix com QR e contador

### AC-9: Webhook Idempotente + Atualização Pagamento/Pedido/Liberação + Auditoria
- **Type**: `rule`
- **Given**: Pedido criado com pagamento `awaiting_payment` e webhook `/api/webhooks/mercadopago/{token}`
- **When**: Enviar payload `approved` 3 vezes consecutivas com mesmo `x-idempotency-key` ou ID MP
- **Then**: Apenas 1ª execução processa (atualiza pagamento aprovado, pedido paid→available, libera fotos, dispara e-mail, grava audit). 2ª e 3ª retornam 200/204 SEM reprocessar. Validação de assinatura/token do webhook bloqueia payload inválido (403).
- **Pass Condition**: `payment_webhooks` contém 1 registro processado e 2 idempotentes/ignorados; pedido processou liberação uma única vez; `payment_transactions` não duplicado
- **Evidence**: Banco `payment_webhooks` (3 linhas, 1 processed=true) + `audit_logs` com 1 entrada de aprovação + request inválido retorna 403

### AC-10: Snapshot Monetário do Pedido (DECIMAL 12,2) + Sem Float + Valores Preservados Após Alteração de Preço
- **Type**: `rule`
- **Given**: Pedido criado com Foto A preço R$ 19,90, tamanho HD, desconto 5%
- **When**: Alterar o preço base da Foto A para R$ 29,90 no painel
- **Then**: Consultar `order_items` do pedido antigo: preço snapshot continua R$ 19,90, desconto 5%, valores preservados. Todas colunas monetárias em migrations são `DECIMAL(12,2)` (nenhuma `FLOAT`/`DOUBLE`).
- **Pass Condition**: `grep -r "FLOAT\|DOUBLE" database/migrations/` retorna vazio para campos monetários; `order_items.unit_price` permanece inalterado após update em `photos.price`
- **Evidence**: Busca em migrations + snapshot `order_items` antes/depois (diferença zero) + screenshot consulta SQL

### AC-11: Download Seguro (Autorização + IP Logado) + Originais Nunca Públicos + ZIP
- **Type**: `rule`
- **Given**: Pedido pago (available) e cliente logado; também tentativa de usuário não autorizado sabendo a URL
- **When**: Cliente logado baixa foto individual e pedido ZIP; usuário aleatório tenta mesma rota/URL direta do original
- **Pass Condition**: Cliente autorizado recebe download com registro em tabela de logs (cliente, arquivo, pedido, data, IP); não autorizado recebe 403; arquivo original em `storage/app/private/...` SEM link simbólico para público e SEM rota direta; rota de download passa por controller que validou `pedido.available === true && order_item pertence ao usuário`
- **Evidence**: Rotas web `download` com middleware auth/policy; inspeção filesystem (originais fora de public/); download_log existente + 403 em request não autorizado

### AC-12: Estorno Total e Parcial por Item com Histórico + NUNCA Apaga Pedido
- **Type**: `rule`
- **Given**: Pedido pago com 3 itens
- **When**: Solicitar estorno de 1 item (parcial) e depois estorno total
- **Then**: Cria `refunds` e `refund_items` respectivos, pedido evolui de paid → partially_refunded → refunded; histórico completo; NENHUM registro de pedido/itens é deletado; `deleted_at` nem físico ocorre
- **Pass Condition**: `refunds` possui 2 registros (1 parcial, 1 total); `orders.status` = refunded; `orders` e `order_items` ainda contêm todas linhas originais
- **Evidence**: Snapshot tabelas `refunds/refund_items/orders/order_items` + ausência de `DELETE FROM orders` em código (via grep)

### AC-13: Painel do Cliente /minha-conta (Dashboard, Pedidos, Downloads, Estornos, Tickets, Segurança)
- **Type**: `rule`
- **Given**: Cliente autenticado com pedido pago + 1 ticket aberto + 1 download realizado
- **When**: Navegar em cada menu de `/minha-conta`
- **Then**: Todas seções existem e exibem dados reais do cliente (sem vazar dados de outros clientes — teste IDOR manipulando ?order_id=OUTRO). Criar ticket anexa arquivo e vincula pedido.
- **Pass Condition**: 6 seções do menu renderizam com dados; manipular `?order_id=<id de outro cliente>` retorna 403; novo ticket criado em `tickets` com `user_id` correto
- **Evidence**: Screenshots de 4 seções + request IDOR (403) + linha no banco `tickets`

### AC-14: Storage Driver Interface + Local Obrigatório + Google Drive Opcional (Sem Impedimento)
- **Type**: `rule`
- **Given**: `config/filesystems.php` com driver `photo` que resolve para LocalStorageDriver ou GoogleDriveStorageDriver
- **When**: Configurar `STORAGE_DRIVER=local` e rodar upload, depois desligar/remover credenciais Google Drive e rodar novamente
- **Then**: `StorageDriverInterface` existe com `store/get/delete/url`; LocalStorageDriver funciona 100%; ausência de credenciais Google Drive NÃO quebra upload/download (core funciona no local); GoogleDrive implementado mas não carregado quando não configurado
- **Pass Condition**: Arquivos `StorageDriverInterface.php`, `LocalStorageDriver.php`, `GoogleDriveStorageDriver.php` existem; desligar Google Drive (env vazio) continua rodando sem erros
- **Evidence**: Código interfaces/adapters + log sem erros com GD desligado + upload/download OK em modo local

### AC-15: SMTP Configurável no Painel + Botão "Enviar E-mail de Teste" com Toast
- **Type**: `rule`
- **Given**: Usuário com `smtp.manage`
- **When**: Preencher SMTP no painel (host/porta/usuário/senha/criptografia/remetente/nome/reply-to) e clicar em "Enviar e-mail de teste" informando destinatário real
- **Then**: Senha salva NÃO é reexibida em nenhum HTML/JSON; envio usa configurações do painel em runtime; Notify/Toast exibe sucesso ou falha detalhada sem expor credenciais; logs de envio gravados sem senha
- **Pass Condition**: HTML do formulário NÃO contém valor no input senha; request de envio retornou toast coerente; `email_logs` gravou sem expor senha
- **Evidence**: HTML source (input password sem value) + toast screenshot + registro em `email_logs` com credenciais mascaradas/removidas

### AC-16: Central de Templates de E-mail + Nenhum HTML Escrito Diretamente em Controllers
- **Type**: `rule`
- **Given**: Seeders rodados criando templates padrão
- **When**: Listar templates em Administração → E-mails → Templates e disparar fluxos reais (pedido criado, pagamento aprovado, Pix gerado, estorno etc.)
- **Then**: Todos 24 templates listados na especificação existem com nome/assunto/HTML (Summernote)/texto/ativo/variáveis/preview/envio teste. Controllers NÃO contêm HTML inline; todos usam `Mail` + view de e-mail com conteúdo vindo do template do banco.
- **Pass Condition**: 24 registros em `email_templates`; busca `grep -r "<html>\|<body>\|<table.*width" app/Http/Controllers` retorna vazio; fluxo "pagamento aprovado" envia e-mail usando conteúdo do template
- **Evidence**: `select count(*) from email_templates` = 24; grep negativo; e-mail recebido em caixa de teste

### AC-17: Dashboard AdminLTE 4 com Dados REAIS e Filtros de Período
- **Type**: `rule`
- **Given**: Banco com pedidos pagos, clientes, álbuns, visitas populados por fluxos reais (não seeders falsos)
- **When**: Abrir Dashboard e trocar filtros (hoje / 7 dias / 30 dias / mês atual / período personalizado)
- **Then**: Cards/widgets mostram valores consistentes com consultas SQL reais, dados batem; filtros alteram corretamente os resultados. Nenhum widget usa dado hardcoded/falso.
- **Pass Condition**: Somar `paid` orders do período via SQL igual ao número exibido no widget "Pedidos Aprovados". Mesmo para faturamento (SUM total_paid).
- **Evidence**: Consulta SQL lado a lado com valores do widget (iguais) + screenshot dashboard com 6 widgets reais

### AC-18: Central de Cron + 5 Comandos photo-commerce:* + Instrução cPanel
- **Type**: `rule`
- **Given**: Scheduler configurado em `app/Console/Kernel.php`
- **When**: Abrir Administração → Sistema → Cron; executar `php artisan list`
- **Then**: Tabela exibe tarefa, descrição, frequência, última/próxima execução, duração, status, último erro. `php artisan list` mostra `photo-commerce:expire-payments`, `photo-commerce:cleanup`, `photo-commerce:process-emails`, `photo-commerce:process-images`, `photo-commerce:generate-analytics`. README contém instrução cron compatível com cPanel (`* * * * * cd /home/user/app/Laravel && php artisan schedule:run >> /dev/null 2>&1`).
- **Pass Condition**: 5 comandos listados; tela Central de Cron renderiza com pelo menos tarefas + frequência; README contém linha cron cPanel
- **Evidence**: Saída `php artisan list | grep photo-commerce`; screenshot central cron; linha do README

### AC-19: SEO Completo, Keywords Tag, Sitemap Dinâmico (Nunca Inclui Páginas Privadas)
- **Type**: `rule`
- **Given**: Álbum público, álbum privado, página de checkout
- **When**: Renderizar home, acessar `/sitemap.xml`, criar keywords "fotógrafo casamento" (Enter)
- **Then**: Home/álbum público possuem OG/Twitter/title/description/canonical; keyword digitada vira chip `[ fotógrafo casamento × ]` salva individualmente sem duplicatas. Sitemap contém apenas páginas públicas/indexáveis; NÃO contém URLs `/admin/*`, `/login`, `/minha-conta/*`, `/checkout/*`, `/downloads/*`, `/tickets/*`.
- **Pass Condition**: `/sitemap.xml` validado com XML válido + grep negativo para admin/login/minha-conta/checkout/downloads/tickets; keyword inserida salva 1 linha em `seo_keywords` (duplicatas bloqueadas)
- **Evidence**: XML fonte sitemap + screenshot keywords UI + `seo_keywords` tabela

### AC-20: Visitas + UTM + Origem (Google/Instagram/Facebook/WhatsApp/Direto/Referência) Dashboard Conversão
- **Type**: `rule`
- **Given**: Acessar home via `?utm_source=google&utm_medium=cpc&utm_campaign=casamento` e também via referer instagram.com
- **When**: Abrir dashboard Analytics
- **Then**: Tabelas `visitors/visitor_sessions/traffic_sources` gravam sessão, página, referer, UTM completo, dispositivo, navegador, SO. Dashboard exibe visitas, visitantes, visualizações, carrinhos, checkouts, compras, conversão. Origem é classificada corretamente como Google e Instagram nos respectivos acessos.
- **Pass Condition**: 2 sessões distintas em `visitor_sessions` com `utm_source=google` e `referer like '%instagram%'`; origem dashboard exibe corretamente
- **Evidence**: Linhas em `traffic_sources` + screenshot widget de origem + widget conversão

### AC-21: Migrations Completas, Sem Multi-Tenant, Tests Essenciais Passando, Seeders Apenas Base
- **Type**: `rule`
- **Given**: Ambiente configurado, DB criado
- **When**: Executar `php artisan migrate --seed` e depois `php artisan test` (ou `vendor/bin/pest`)
- **Then**: Todas tabelas da lista FR-18 criadas com sucesso (sem multi-tenant: nenhuma coluna `tenant_id/photographer_id` exceto `photographer_profile` para perfil do dono). Seeders criam apenas roles/permissões/configurações/templates/estados. Testes essenciais (login, permissões, carrinho, pagamento/webhook, download, estorno) passam.
- **Pass Condition**: `SHOW TABLES` contém todas tabelas; `photographer_profile` é tabela única (1 linha); seeders NÃO inserem orders/payments; suíte testes retorna 0 falhas em testes essenciais
- **Evidence**: Saída `migrate --seed`; count orders/payments pós-seed = 0; saída de testes passando

### AC-22: Arquitetura Desacoplada (Nenhuma Regra Complexa em Controller) + PSR-12 + Type Hints
- **Type**: `rubric`
- **Dimension**: Qualidade da arquitetura desacoplada e aderência a PSR-12/type hints
- **Scale**: 1-5
- **Anchors**: 1 = lógica complexa toda em Controllers, sem Services/DTOs; 3 = alguma separação mas regras de desconto/bônus/pagamento ainda em Controllers; 5 = Controllers finos delegam para Services/Actions/DTOs/Repositories/Contracts, todos com type hints/return types, PSR-12 em classes principais, Payment e Storage usam Interfaces + Adapters
- **Pass Threshold**: >= 4
- **Evidence**: Inspecionar 5 Controllers essenciais (Cart, Checkout, Album, Photo, Refund) e verificar delegação para Services/Actions; presença de DTOs e Interfaces

### AC-23: Responsividade (Mobile/Tablet/Desktop) — AdminLTE 4 + Frontend Público + Login
- **Type**: `rubric`
- **Dimension**: Qualidade responsiva em breakpoints críticos
- **Scale**: 1-5
- **Anchors**: 1 = quebra visual grave em mobile (sidebar não recolhível, tabelas transbordando horizontal, checkout impossível); 3 = funciona mas overlaps/margens ruins em tablet; 5 = AdminLTE com sidebar recolhível mobile, tabelas responsive, checkout otimizado mobile com campos em coluna única, login mobile sem coluna foto, frontend público com galeria adaptativa, tudo sem overflow horizontal em 320px
- **Pass Threshold**: >= 4
- **Evidence**: Screenshots DevTools em 320px, 768px, 1280px (painel e loja), nenhum overflow horizontal detectado

### AC-24: Segurança Completa (CSRF/XSS/SQLi/IDOR/Rate Limit/Webhook Assinado) — Sem Credenciais em Logs
- **Type**: `rule`
- **Given**: Sistema rodando com configurações padrão
- **When**: Tentar: (a) POST sem token CSRF → rejeitado; (b) <script> em descrição de álbum → escapado; (c) ?order_id=outro_cliente → 403; (d) 30 tentativas login em 1 min → bloqueado; (e) webhook MP com token errado → 403; (f) procurar senha SMTP em logs → não encontrado
- **Then**: Todos 6 cenários passam. Nenhuma senha/CVV/secret em `storage/logs` ou `audit_logs` ou `email_logs`.
- **Pass Condition**: 6/6 testes manuais acima passam; `grep -r "smtp_password\|senha\|secret" storage/logs` vazio
- **Evidence**: Resultado de cada teste de segurança + grep negativo em logs

### AC-25: Deploy Compatível cPanel (Fora public_html) + README Passo a Passo
- **Type**: `rule`
- **Given**: Estrutura Laravel criada
- **When**: Ler README e verificar estrutura recomendada `/home/usuario/app/Laravel` + `/home/usuario/public_html`
- **Then**: README contém 11 passos de deploy cPanel: criação do banco, configuração .env, Composer, migrate, storage:link, permissões, cron, queue, domínio/SSL, produção. `.env.example` NÃO contém credenciais reais. `.env` NÃO está commitado (gitignore padrão Laravel + explícito se necessário).
- **Pass Condition**: README.md contém as 11 seções de deploy cPanel; `.gitignore` contém `.env`; `.env.example` contém placeholders `MERCADO_PAGO_ACCESS_TOKEN=your_token_here` etc.
- **Evidence**: README seções 1..11; `.gitignore`; `.env.example` placeholders (sem valores reais)

### AC-26: Regras Absolutas do Projeto Cumpridas (77 seções → Nenhuma Violação Grave)
- **Type**: `rubric`
- **Dimension**: Cumprimento das 34 regras absolutas elencadas no item #77 da especificação original
- **Scale**: 1-5
- **Anchors**: 1 = 10+ violações graves (multi-tenant, sem AdminLTE, Summernote parcial, alert() nativo, etc); 3 = 2-5 violações leves; 5 = 0 violações: 1 fotógrafo apenas, sem multi-tenant/marketplace, AdminLTE 4 estrutural, Summernote obrigatório, Bootstrap, SweetAlert2 + Notify/Toast, Laravel+PHP8.4, cPanel compatível, checkout transparente, MP real com webhook idempotente, originais protegidos, Google Drive opcional, SMTP painel, templates e-mail, central cron, RBAC, painel cliente, estorno total/parcial, desconto progressivo, bônus, banners, SEO, analytics/UTM, drag&drop, doc cPanel, sem fake/sem TODOs essenciais, sem credenciais reais, sem expor sensíveis
- **Pass Threshold**: >= 4
- **Evidence**: Checklist dos 34 itens #77 com marcação cumprido, 0 violações graves

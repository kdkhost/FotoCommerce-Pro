<div align="center">

# 📸 FotoCommerce Pro

### Sistema Completo para Fotógrafos Profissionais Venderem Fotos Digitais

![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat&logo=php&logoColor=white&labelColor=111827)
![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat&logo=laravel&logoColor=white&labelColor=111827)
![AdminLTE](https://img.shields.io/badge/AdminLTE-v4.0-20A8E4?style=flat&labelColor=111827)
![MercadoPago](https://img.shields.io/badge/Checkout-Mercado%20Pago-009ee3?style=flat&labelColor=111827)
![License](https://img.shields.io/badge/License-MIT-22c55e?style=flat&labelColor=111827)

**Versão 1.0.0-RC1 · Build 25/09/2026 · Organização @kdkhost**

[Instalação (5 min)](#-instalação-rápida) · [Funcionalidades](#-funcionalidades-principais) · [Receita Exemplo](#-simulação-receita-mensal) · [Autor](#-autor-oficial)

</div>

---

## 🚀 Instalação Rápida

> **Pré-requisitos:** PHP 8.3, Composer 2.7+, Node 20+, MySQL 8+ ou MariaDB 10.11+

```bash
# 1. Clonar
  git clone https://github.com/kdkhost/FotoCommerce-Pro.git && cd FotoCommerce-Pro

# 2. Dependências PHP + JS
  composer install --no-interaction && npm install

# 3. .env + chave
  copy .env.example .env  &&  php artisan key:generate

# 4. Edite o .env → configurar DB + MERCADOPAGO_ACCESS_TOKEN

# 5. Migrar + popular roles, 24 templates e tamanhos de foto
  php artisan migrate:fresh --seed

# 6. Publicar AdminLTE + Permissions
  php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\AdminLteServiceProvider" --tag=assets --force
  php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

# 7. Criar Super Admin inicial
  php artisan photo-commerce:create-admin --name="Marcelo Brad" --email="admin@fotografia.com" --password="SuperAdmin@2026!"

# 8. Build + subir
  npm run build  &&  php artisan serve
```

**Login Admin →** `http://localhost:8000/admin`

---

## ✨ Funcionalidades Principais (23 Tasks Concluídas)

| Módulo | Principais entregas |
|---|---|
| 🔐 **Segurança / RBAC** | 3 papéis (Super Admin / Admin / Cliente) + 62 permissões + 17 Policies. Session encrypt, httpOnly, SameSite Lax, Rate Limiter (30 login/min) |
| 💳 **Pagamento** | Mercado Pago oficial: **PIX QR Copia-e-Cola** + Cartão de Crédito. Webhooks idempotentes com log completo |
| 💸 **Estornos** | Integrais e **Parciais** nativos. Tela com confirmação IRREVERSÍVEL obrigatória (digitar IRREVERSIVEL) |
| 🛒 **Carrinho** | Cupom %/R$ + Desconto Progressivo (10fotos=3%, 30=5%, 50=7%, 100=10%) + **Bônus 1 grátis a cada 10 pagas** + Repasse de taxa %/fixo |
| 📸 **Fotos** | 8 tamanhos por upload, **marca d'água automática** (1600px), extração de EXIF (GPS, câmera, lente, ISO, abertura), Drag & Drop, reordenação SortableJS |
| 🗂️ **Álbuns** | Categorias. 3 visibilidades: **Público**, **Privado**, **Protegido por Senha** (gate porta segura). 1 foto destaque ⭐ |
| ⬇️ **Downloads** | Autenticados por token hash. **Máx 5 downloads/foto** com transação atômica (evita paralelismo). Janela de **2 anos**. ZIP por pedido com limite 3/dia |
| 🎫 **Atendimento** | Tickets com categorias, anexos 10MB, FAQ accordion, fechamento automático idle 7 dias |
| 👤 **Painel Cliente** | Meus pedidos, downloads liberados, perfil (CPF, nascimento, gênero), senha. **Excluir Conta LGPD** (anonymize + hard-delete bloqueado) |
| 🌍 **Site Público** | Home temática (cores + fontes via Admin), galeria Lightbox, orçamento com consentimento LGPD, página "Quem Somos" + Instagram/WhatsApp |
| 🔎 **SEO** | Sitemap.xml dinâmico (álbuns publicados), robots.txt bloqueando admin/customer, meta OG + canonical por página |
| 📊 **Analytics** | Visitor Log com throttling IP/minuto. Detecção de **12 bots/crawlers** (Googlebot, Semrush, Ahrefs, Bing etc.) |
| ⏱️ **Cron** | Limpa pedidos expirados + chunks órfãos (hora a hora). Relatório diário 08:00 receita/pedidos/visitas por e-mail. `withoutOverlapping` |
| 📧 **E-mails** | 24 templates nativos com editor **Summernote WYSIWYG**. SMTP runtime (password Crypt::encryptString mascarado). Envio de teste com timeout 30s |
| ☁️ **Storage** | Arquitetura Contract Pattern: **LocalDriver Intervention 4** + esqueleto Google Drive (futuro cold storage) |
| 🧪 **Testes** | 3 suites PHPUnit Feature: Checkout carrinho+cupom, Webhook MercadoPago mockado, Auth redirect por role |

---

## 💰 Simulação Receita Mensal (Ticket Médio R$ 180)

| Cenário 100 pedidos / mês | Valor |
|---|---|
| Fotos vendidas (média 18/pedido) | **1.800 fotos** |
| Receita bruta | R$ **18.000,00** |
| (-) Taxa Mercado Pago (~0,99%+R$0,50) | R$ 229,00 |
| (-) Hospedagem/Domínio | R$ 60,00 |
| **Lucro líquido estimado** | 👉 **R$ 17.711,00 / mês** |

> Sem mensalidade de plataformas terceiras (Kwai, Pixieset, ShootProof). 100% do faturamento e 100% dos dados dos clientes = **SEUS**.

---

## 🔒 Conformidade Brasil

✅ **LGPD**: Cliente pode excluir própria conta a qualquer momento (anonimização + log). Consentimento explícito em formulários.
✅ **SSL obrigatório em produção** (APP_ENV=production → session.secure=true)
✅ **Páginas estáticas**: Termos de Uso, Política de Privacidade e LGPD
✅ **Rastreabilidade**: Tabelas `audit_logs`, `refunds`, `payments`, `download_logs`, `tickets`

---

## 🧱 Pilha Tecnológica
- **Backend**: PHP 8.3 + Laravel 13 (Contracts, Enum tipados, Policies, Jobs Queue, Schedule)
- **Painel Admin**: AdminLTE v4 + Bootstrap 5 + Bootstrap Icons
- **Front**: Vite 6 + jQuery 3.7 + Summernote 0.8.20 + Dropzone 6 + SortableJS + Lightbox2
- **UX Modais**: SweetAlert2 (nunca alert/confirm/prompt nativo) + Bootstrap 5 Toasts (Notify)
- **Pagamento**: Mercado Pago DX PHP v3.16
- **Imagens**: Intervention Image 4 (GD Driver)
- **Banco**: MySQL 8+ / MariaDB 10.11+ — **100% DECIMAL(12,2) monetário (zero FLOAT/DOUBLE)**
- **Testes**: PHPUnit 12 + Mockery

---

## 📄 Documentação Adicional
👉 **[CHANGELOG.md](./CHANGELOG.md)** (histórico versões — mais recente no topo)
👉 **[AGENTS.md](./AGENTS.md)** (regras monetárias, UI, LGPD do sistema)

---

## 👨‍💼 Autor Oficial

| Canal | Contato |
|---|---|
| 📞 **WhatsApp / Telefone** | [**+55 21 98132-5441**](https://wa.me/5521981325441) |
| 📧 **E-mail** | [**contato@kdkhost.com.br**](mailto:contato@kdkhost.com.br) |
| 💬 **Telegram** | [**@MARCELO_BRAD**](https://t.me/MARCELO_BRAD) |
| 📸 **Instagram** | [**@marcelobradrj**](https://instagram.com/marcelobradrj) |
| 🏢 **Organização GitHub** | [**@kdkhost**](https://github.com/kdkhost) |

---

## 📜 Licença
Projeto licenciado **MIT** — Uso comercial permitido, **desde que seja mantido o PHPDoc `@autor marcelo-brad rj` nos cabeçalhos dos arquivos PHP originais**.

<div align="center">

**⭐ Se este projeto te ajudou, deixe uma estrela no GitHub!**
Feito com 🇧🇷 ❤️ por marcelo-brad rj para fotógrafos profissionais brasileiros.

</div>

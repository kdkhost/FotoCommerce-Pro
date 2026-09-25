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

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'slug' => 'password_reset',
                'name' => 'Recuperação de Senha',
                'subject' => 'Defina sua nova senha',
                'body_html' => '<p>Olá {{user.name}},</p><p>Clique no link abaixo para redefinir sua senha:</p><p><a href="{{reset.link}}">{{reset.link}}</a></p>',
                'variables_json' => ['{{user.name}}', '{{reset.link}}'],
            ],
            [
                'slug' => 'registration_confirmation',
                'name' => 'Confirmação de Cadastro',
                'subject' => 'Bem-vindo ao nosso portal',
                'body_html' => '<p>Olá {{user.name}},</p><p>Seu cadastro foi realizado com sucesso! Acesse:</p><p><a href="{{login.link}}">{{login.link}}</a></p>',
                'variables_json' => ['{{user.name}}', '{{login.link}}'],
            ],
            [
                'slug' => 'email_verification',
                'name' => 'Verificação de E-mail',
                'subject' => 'Verifique seu e-mail',
                'body_html' => '<p>Olá {{user.name}},</p><p>Confirme seu e-mail clicando no link:</p><p><a href="{{verify.link}}">{{verify.link}}</a></p>',
                'variables_json' => ['{{user.name}}', '{{verify.link}}'],
            ],
            [
                'slug' => 'order_created',
                'name' => 'Pedido Criado',
                'subject' => 'Seu pedido foi recebido',
                'body_html' => '<p>Olá,</p><p>Seu pedido <strong>{{order.number}}</strong> foi recebido. Total: R$ {{order.total}}.</p><p><a href="{{order.link}}">Ver detalhes</a></p>',
                'variables_json' => ['{{order.number}}', '{{order.total}}', '{{order.link}}'],
            ],
            [
                'slug' => 'payment_pending',
                'name' => 'Pagamento Pendente',
                'subject' => 'Aguardando pagamento do pedido',
                'body_html' => '<p>Olá,</p><p>Estamos aguardando o pagamento do pedido {{order.number}} no valor de R$ {{payment.value}}.</p>',
                'variables_json' => ['{{order.number}}', '{{payment.value}}'],
            ],
            [
                'slug' => 'pix_generated',
                'name' => 'Pix Gerado',
                'subject' => 'PIX disponível para pagamento',
                'body_html' => '<p>Olá,</p><p>PIX do pedido {{order.number}} gerado.</p><p>Copy e Paste: {{pix.copy_paste}}</p><p>Expira em: {{pix.expires_at}}</p>',
                'variables_json' => ['{{order.number}}', '{{pix.copy_paste}}', '{{pix.expires_at}}'],
            ],
            [
                'slug' => 'payment_approved',
                'name' => 'Pagamento Aprovado',
                'subject' => 'Pedido pago — fotos liberadas!',
                'body_html' => '<p>Olá,</p><p>Seu pedido {{order.number}} foi pago em {{payment.paid_at}}.</p><p>Baixe suas fotos: <a href="{{downloads.link}}">{{downloads.link}}</a></p>',
                'variables_json' => ['{{order.number}}', '{{payment.paid_at}}', '{{downloads.link}}'],
            ],
            [
                'slug' => 'payment_declined',
                'name' => 'Pagamento Recusado',
                'subject' => 'Não foi possível processar',
                'body_html' => '<p>Olá,</p><p>Não foi possível processar o pagamento do pedido {{order.number}}.</p><p>Motivo: {{reason}}</p>',
                'variables_json' => ['{{order.number}}', '{{reason}}'],
            ],
            [
                'slug' => 'payment_expired',
                'name' => 'Pagamento Expirado',
                'subject' => 'Prazo de pagamento expirou',
                'body_html' => '<p>Olá,</p><p>O prazo de pagamento do pedido {{order.number}} expirou.</p><p><a href="{{retry.link}}">Tentar novamente</a></p>',
                'variables_json' => ['{{order.number}}', '{{retry.link}}'],
            ],
            [
                'slug' => 'order_cancelled',
                'name' => 'Pedido Cancelado',
                'subject' => 'Seu pedido foi cancelado',
                'body_html' => '<p>Olá,</p><p>Seu pedido {{order.number}} foi cancelado.</p>',
                'variables_json' => ['{{order.number}}'],
            ],
            [
                'slug' => 'photos_released',
                'name' => 'Fotos Liberadas',
                'subject' => 'Suas fotos estão disponíveis',
                'body_html' => '<p>Olá,</p><p>As fotos do álbum {{album.name}} no pedido {{order.number}} foram liberadas.</p><p><a href="{{downloads.link}}">Baixar agora</a></p>',
                'variables_json' => ['{{order.number}}', '{{album.name}}', '{{downloads.link}}'],
            ],
            [
                'slug' => 'download_available',
                'name' => 'Download Disponível',
                'subject' => 'Baixe suas fotografias',
                'body_html' => '<p>Olá,</p><p>Seu pedido {{order.number}} está pronto para download.</p><p><a href="{{downloads.link}}">Acessar downloads</a></p>',
                'variables_json' => ['{{order.number}}', '{{downloads.link}}'],
            ],
            [
                'slug' => 'refund_requested',
                'name' => 'Estorno Solicitado',
                'subject' => 'Recebemos seu pedido de estorno',
                'body_html' => '<p>Olá,</p><p>Recebemos sua solicitação de estorno do pedido {{order.number}} no valor de R$ {{refund.amount}}.</p>',
                'variables_json' => ['{{order.number}}', '{{refund.amount}}'],
            ],
            [
                'slug' => 'refund_approved',
                'name' => 'Estorno Aprovado',
                'subject' => 'Estorno realizado com sucesso',
                'body_html' => '<p>Olá,</p><p>Seu estorno do pedido {{order.number}} foi aprovado.</p><p>Valor: R$ {{refund.amount}}</p><p>Data: {{refund.date}}</p>',
                'variables_json' => ['{{order.number}}', '{{refund.amount}}', '{{refund.date}}'],
            ],
            [
                'slug' => 'refund_rejected',
                'name' => 'Estorno Recusado',
                'subject' => 'Motivo da recusa do estorno',
                'body_html' => '<p>Olá,</p><p>Infelizmente seu estorno do pedido {{order.number}} foi recusado.</p><p>Motivo: {{reason}}</p>',
                'variables_json' => ['{{order.number}}', '{{reason}}'],
            ],
            [
                'slug' => 'ticket_created',
                'name' => 'Ticket Aberto',
                'subject' => 'Recebemos sua solicitação',
                'body_html' => '<p>Olá,</p><p>Seu ticket #{{ticket.id}} — {{ticket.subject}} foi aberto.</p><p><a href="{{ticket.link}}">Acompanhar</a></p>',
                'variables_json' => ['{{ticket.id}}', '{{ticket.subject}}', '{{ticket.link}}'],
            ],
            [
                'slug' => 'ticket_answered',
                'name' => 'Resposta de Ticket',
                'subject' => 'Há uma nova resposta no seu ticket',
                'body_html' => '<p>Olá,</p><p>Seu ticket #{{ticket.id}} recebeu uma nova resposta.</p><p><a href="{{ticket.link}}">Ver resposta</a></p>',
                'variables_json' => ['{{ticket.id}}', '{{ticket.link}}'],
            ],
            [
                'slug' => 'promotion',
                'name' => 'Promoção Exclusiva',
                'subject' => 'Aproveite esta oferta especial',
                'body_html' => '<p>Olá,</p><p>Promoção: {{promotion.title}}</p><p><a href="{{promotion.link}}">Aproveitar</a></p><p>Válido até: {{promotion.expires_at}}</p>',
                'variables_json' => ['{{promotion.title}}', '{{promotion.link}}', '{{promotion.expires_at}}'],
            ],
            [
                'slug' => 'contact_form',
                'name' => 'Formulário de Contato',
                'subject' => 'Nova mensagem de contato recebida',
                'body_html' => '<p>Nova mensagem recebida:</p><p>De: {{sender.name}} ({{sender.email}})</p><p>Mensagem: {{message}}</p>',
                'variables_json' => ['{{sender.name}}', '{{sender.email}}', '{{message}}'],
            ],
            [
                'slug' => 'password_changed',
                'name' => 'Senha Alterada',
                'subject' => 'Sua senha foi atualizada',
                'body_html' => '<p>Olá {{user.name}},</p><p>Sua senha foi alterada com sucesso em {{date}}.</p>',
                'variables_json' => ['{{user.name}}', '{{date}}'],
            ],
            [
                'slug' => 'email_changed',
                'name' => 'E-mail Alterado',
                'subject' => 'Seu endereço de e-mail foi atualizado',
                'body_html' => '<p>Olá {{user.name}},</p><p>Seu e-mail foi alterado para: {{new.email}}</p>',
                'variables_json' => ['{{user.name}}', '{{new.email}}'],
            ],
            [
                'slug' => 'admin_alert',
                'name' => 'Alerta Administrativo',
                'subject' => 'Atenção: evento no sistema',
                'body_html' => '<p>Alerta administrativo:</p><p><strong>{{alert.title}}</strong></p><p>{{alert.message}}</p>',
                'variables_json' => ['{{alert.title}}', '{{alert.message}}'],
            ],
            [
                'slug' => 'smtp_test',
                'name' => 'Teste de SMTP',
                'subject' => 'E-mail de teste enviado com sucesso',
                'body_html' => '<p>Configuração SMTP OK!</p><p>Data: {{test.date}}</p><p>Destinatário: {{test.recipient}}</p>',
                'variables_json' => ['{{test.date}}', '{{test.recipient}}'],
            ],
        ];

        foreach ($templates as $tpl) {
            EmailTemplate::create([
                'slug' => $tpl['slug'],
                'name' => $tpl['name'],
                'subject' => $tpl['subject'],
                'body_html' => $tpl['body_html'],
                'variables_json' => $tpl['variables_json'],
                'language' => 'pt_BR',
                'is_active' => true,
            ]);
        }
    }
}

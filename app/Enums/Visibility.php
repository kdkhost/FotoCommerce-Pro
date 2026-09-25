<?php
/**
 * @autor marcelo-brad rj
 * @contato Tel: 21 981325441
 * Email: contato@kdkhost.com.br
 * Telegram: @MARCELO_BRAD
 * Instagram: @marcelobradrj
 * WhatsApp: 21981325441
 */

namespace App\Enums;

enum Visibility: string
{
    case Public = 'public';
    case Private = 'private';
    case Password = 'password';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}

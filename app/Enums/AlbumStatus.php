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

enum AlbumStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Private = 'private';
    case Archived = 'archived';
    case Closed = 'closed';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}

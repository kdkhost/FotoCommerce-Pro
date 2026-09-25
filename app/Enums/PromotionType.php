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

enum PromotionType: string
{
    case Popup = 'popup';
    case FloatingBanner = 'floating_banner';
    case TopBar = 'top_bar';
    case Carousel = 'carousel';
    case Modal = 'modal';
    case AlbumBanner = 'album_banner';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}

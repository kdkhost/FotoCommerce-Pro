<?php
/**
 * @autor marcelo-brad rj
 * @contato Tel: 21 981325441
 * Email: contato@kdkhost.com.br
 * Telegram: @MARCELO_BRAD
 * Instagram: @marcelobradrj
 * WhatsApp: 21981325441
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageSetting extends Model
{
    protected $table = 'storage_settings';

    protected $primaryKey = 'single_row_lock';

    public $incrementing = false;

    protected $fillable = [
        'single_row_lock',
        'driver',
        'google_client_id',
        'google_client_secret_encrypted',
        'google_refresh_token_encrypted',
        'google_folder_id',
        'google_auth_json_path',
        'last_sync_at',
        'sync_enabled',
    ];

    protected function casts(): array
    {
        return [
            'last_sync_at' => 'datetime',
            'sync_enabled' => 'boolean',
        ];
    }
}

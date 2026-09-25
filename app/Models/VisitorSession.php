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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitorSession extends Model
{
    protected $fillable = [
        'session_uuid',
        'user_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'os',
        'referer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'do_not_track',
        'first_visited_at',
        'last_visited_at',
    ];

    protected function casts(): array
    {
        return [
            'do_not_track' => 'boolean',
            'first_visited_at' => 'datetime',
            'last_visited_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class, 'visitor_session_id');
    }

    public function trafficSources(): HasMany
    {
        return $this->hasMany(TrafficSource::class, 'visitor_session_id');
    }
}

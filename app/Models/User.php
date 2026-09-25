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

use App\Enums\UserType;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'cpf',
        'phone',
        'avatar',
        'last_login_at',
        'last_login_ip',
        'blocked_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserType::class,
            'last_login_at' => 'datetime',
            'blocked_at' => 'datetime',
        ];
    }

    public function photographerProfile(): HasOne
    {
        return $this->hasOne(PhotographerProfile::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class, 'user_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assignee_admin_id');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }

    public function downloadLogs(): HasMany
    {
        return $this->hasMany(DownloadLog::class, 'user_id');
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class, 'user_id');
    }

    public function visitorSessions(): HasMany
    {
        return $this->hasMany(VisitorSession::class, 'user_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id');
    }
}

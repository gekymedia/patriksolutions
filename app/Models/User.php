<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'photo',
        'telegram_chat_id',
        'sms_notifications_enabled',
        'whatsapp_notifications_enabled',
        'telegram_notifications_enabled',
        'gekychat_notifications_enabled',
        'email_notifications_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'sms_notifications_enabled' => 'boolean',
            'whatsapp_notifications_enabled' => 'boolean',
            'telegram_notifications_enabled' => 'boolean',
            'gekychat_notifications_enabled' => 'boolean',
            'email_notifications_enabled' => 'boolean',
        ];
    }

    /**
     * The guard name used by Spatie's role and permission package.
     */
    protected string $guard_name = 'web';

    /**
     * Check if user has admin access
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin') || $this->role === 'admin';
    }
}

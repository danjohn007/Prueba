<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
        'phone',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];

    // Relaciones
    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function collaboratedBusinesses()
    {
        return $this->hasMany(Business::class, 'collaborator_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'collaborator_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Scopes
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeCollaborators($query)
    {
        return $query->where('role', 'collaborator');
    }

    public function scopeBusinesses($query)
    {
        return $query->where('role', 'business');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Métodos de utilidad
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCollaborator()
    {
        return $this->role === 'collaborator';
    }

    public function isBusiness()
    {
        return $this->role === 'business';
    }
}
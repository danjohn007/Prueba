<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'collaborator_id',
        'business_name',
        'rfc',
        'business_type',
        'description',
        'website',
        'address',
        'city',
        'state',
        'postal_code',
        'contact_phone',
        'contact_email',
        'status',
        'affiliation_date',
        'expiration_date',
        'commission_rate',
        'active',
        'benefits',
    ];

    protected $casts = [
        'affiliation_date' => 'date',
        'expiration_date' => 'date',
        'commission_rate' => 'decimal:2',
        'active' => 'boolean',
        'benefits' => 'array',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collaborator()
    {
        return $this->belongsTo(User::class, 'collaborator_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereDate('expiration_date', '<=', now()->addDays($days));
    }

    // Métodos de utilidad
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isExpired()
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }

    public function getDaysUntilExpiration()
    {
        if (!$this->expiration_date) return null;
        return now()->diffInDays($this->expiration_date, false);
    }
}
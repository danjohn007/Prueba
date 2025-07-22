<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'business_id',
        'status',
        'registered_at',
        'notes',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    // Relaciones
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Scopes
    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    // Métodos de utilidad
    public function isRegistered()
    {
        return $this->status === 'registered';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function hasAttended()
    {
        return $this->status === 'attended';
    }

    public function isCanceled()
    {
        return $this->status === 'canceled';
    }
}
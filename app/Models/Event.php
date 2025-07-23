<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'max_participants',
        'cost',
        'active',
        'image',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'cost' => 'decimal:2',
        'active' => 'boolean',
    ];

    // Relaciones
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function confirmedRegistrations()
    {
        return $this->hasMany(EventRegistration::class)->where('status', 'confirmed');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('event_date', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->whereDate('event_date', '<', now());
    }

    // Métodos de utilidad
    public function isUpcoming()
    {
        return $this->event_date->isFuture();
    }

    public function isPast()
    {
        return $this->event_date->isPast();
    }

    public function getAvailableSpots()
    {
        if (!$this->max_participants) return null;
        return $this->max_participants - $this->confirmedRegistrations()->count();
    }

    public function isFull()
    {
        if (!$this->max_participants) return false;
        return $this->getAvailableSpots() <= 0;
    }
}
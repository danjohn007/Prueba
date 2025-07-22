<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
        'business_id',
        'commission_amount',
        'commission_percentage',
        'status',
        'earned_date',
        'paid_date',
        'notes',
    ];

    protected $casts = [
        'commission_amount' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'earned_date' => 'date',
        'paid_date' => 'date',
    ];

    // Relaciones
    public function collaborator()
    {
        return $this->belongsTo(User::class, 'collaborator_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // Métodos de utilidad
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }
}
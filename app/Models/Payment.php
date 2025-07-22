<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'payment_reference',
        'amount',
        'payment_method',
        'status',
        'description',
        'due_date',
        'paid_at',
        'transaction_id',
        'invoice_number',
        'invoice_path',
        'payment_data',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'payment_data' => 'array',
    ];

    // Relaciones
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')->whereDate('due_date', '<', now());
    }

    // Métodos de utilidad
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isOverdue()
    {
        return $this->isPending() && $this->due_date->isPast();
    }

    public function getDaysOverdue()
    {
        if (!$this->isOverdue()) return 0;
        return now()->diffInDays($this->due_date);
    }
}
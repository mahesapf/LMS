<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_id',
        'bank_name',
        'amount',
        'payment_date',
        'proof_file',
        'status',
        'validated_by',
        'validated_at',
        'rejection_reason',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'validated_at' => 'datetime',
    ];

    /**
     * Get the registration that owns the payment.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the admin who validated the payment.
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}

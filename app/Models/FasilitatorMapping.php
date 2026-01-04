<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FasilitatorMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fasilitator_id',
        'class_id',
        'status',
        'assigned_date',
        'removed_date',
        'assigned_by',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'removed_date' => 'date',
    ];

    // Relationships
    public function fasilitator()
    {
        return $this->belongsTo(User::class, 'fasilitator_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}

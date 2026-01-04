<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipantMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'participant_id',
        'class_id',
        'status',
        'previous_class_id',
        'enrolled_date',
        'moved_date',
        'removed_date',
        'notes',
        'assigned_by',
    ];

    protected $casts = [
        'enrolled_date' => 'date',
        'moved_date' => 'date',
        'removed_date' => 'date',
    ];

    // Relationships
    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function previousClass()
    {
        return $this->belongsTo(Classes::class, 'previous_class_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}

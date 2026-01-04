<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'participant_id',
        'class_id',
        'fasilitator_id',
        'assessment_type',
        'score',
        'notes',
        'graded_date',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'graded_date' => 'date',
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

    public function fasilitator()
    {
        return $this->belongsTo(User::class, 'fasilitator_id');
    }
}

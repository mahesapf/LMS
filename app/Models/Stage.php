<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'name',
        'description',
        'order',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the class that owns this stage
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get document requirements for this stage
     */
    public function documentRequirements()
    {
        return $this->hasMany(DocumentRequirement::class, 'stage_id');
    }

    /**
     * Check if stage is currently active
     */
    public function isActive()
    {
        return $this->status === 'ongoing';
    }

    /**
     * Check if stage has passed
     */
    public function isPassed()
    {
        if (!$this->end_date) return false;
        return now()->isAfter($this->end_date);
    }

    /**
     * Scope to get stages ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}

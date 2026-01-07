<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activity_id',
        'name',
        'description',
        'max_participants',
        'status',
        'created_by',
    ];

    // Relationships
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fasilitatorMappings()
    {
        return $this->hasMany(FasilitatorMapping::class, 'class_id');
    }

    public function participantMappings()
    {
        return $this->hasMany(ParticipantMapping::class, 'class_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'class_id');
    }

    public function documentRequirements()
    {
        return $this->hasMany(DocumentRequirement::class, 'class_id');
    }

    public function stages()
    {
        return $this->hasMany(Stage::class, 'class_id')->orderBy('order');
    }

    // Helper methods
    public function fasilitators()
    {
        return $this->belongsToMany(User::class, 'fasilitator_mappings', 'class_id', 'fasilitator_id')
            ->wherePivot('status', 'in')
            ->withTimestamps();
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participant_mappings', 'class_id', 'participant_id')
            ->wherePivot('status', 'in')
            ->withTimestamps();
    }
}

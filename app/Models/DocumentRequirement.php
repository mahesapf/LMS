<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'stage_id',
        'document_name',
        'document_type',
        'description',
        'is_required',
        'max_file_size',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /**
     * Get the class that owns this requirement
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the stage that owns this requirement
     */
    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    /**
     * Get uploaded documents for this requirement
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'document_requirement_id');
    }

    /**
     * Check if a participant has uploaded this document
     */
    public function hasUploadedBy($participantId)
    {
        return $this->documents()->where('uploaded_by', $participantId)->exists();
    }

    /**
     * Get the uploaded document by a participant
     */
    public function getUploadedBy($participantId)
    {
        return $this->documents()->where('uploaded_by', $participantId)->first();
    }
}

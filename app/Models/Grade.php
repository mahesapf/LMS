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
        'final_score',
        'grade_letter',
        'status',
        'notes',
        'graded_date',
    ];

    protected $casts = [
        'final_score' => 'decimal:2',
        'graded_date' => 'date',
    ];

    // Method untuk menghitung grade letter berdasarkan final score
    public function calculateGradeLetter()
    {
        $score = $this->final_score;
        
        if ($score >= 85) return 'A';
        if ($score >= 80) return 'A-';
        if ($score >= 75) return 'B+';
        if ($score >= 70) return 'B';
        if ($score >= 65) return 'B-';
        if ($score >= 60) return 'C+';
        if ($score >= 55) return 'C';
        if ($score >= 50) return 'C-';
        if ($score >= 45) return 'D';
        return 'E';
    }

    // Method untuk menentukan status kelulusan
    public function calculateStatus()
    {
        return $this->final_score >= 60 ? 'lulus' : 'tidak_lulus';
    }

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

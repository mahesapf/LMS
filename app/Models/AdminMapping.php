<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'program_id',
        'activity_id',
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
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}

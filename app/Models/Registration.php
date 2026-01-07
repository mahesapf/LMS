<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'user_id',
        'name',
        'phone',
        'email',
        'position',
        'school_name',
        'status',
        'class_id',
    ];

    /**
     * Get the program that owns the registration.
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the class assigned to the registration.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the payment for the registration.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

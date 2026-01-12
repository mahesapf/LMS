<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherParticipant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_id',
        'user_id',
        'nama_lengkap',
        'nip',
        'nik',
        'email',
        'surat_tugas',
    ];

    /**
     * Get the registration that owns the teacher participant.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the user associated with this teacher participant.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

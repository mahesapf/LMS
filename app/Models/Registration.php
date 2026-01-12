<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activity_id',
        'user_id',
        'kepala_sekolah_user_id',
        'name',
        'phone',
        'email',
        'position',
        'nama_sekolah',
        'alamat_sekolah',
        'provinsi',
        'kab_kota',
        'kecamatan',
        'kcd',
        'nama_kepala_sekolah',
        'nik_kepala_sekolah',
        'nomor_telp',
        'jumlah_peserta',
        'jumlah_kepala_sekolah',
        'jumlah_guru',
        'surat_tugas_kepala_sekolah',
        'status',
        'class_id',
    ];

    /**
     * Get the activity that owns the registration.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the kepala sekolah user for this registration.
     */
    public function kepalaSekolahUser()
    {
        return $this->belongsTo(User::class, 'kepala_sekolah_user_id');
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

    /**
     * Get the teacher participants for the registration.
     */
    public function teacherParticipants()
    {
        return $this->hasMany(TeacherParticipant::class);
    }

    /**
     * Calculate total payment amount based on total participants.
     */
    public function calculateTotalPayment()
    {
        if (!$this->activity || $this->activity->registration_fee <= 0) {
            return 0;
        }

        // Total peserta = jumlah_peserta (atau jumlah_kepala_sekolah + jumlah_guru jika jumlah_peserta = 0)
        $totalPeserta = $this->jumlah_peserta > 0
            ? $this->jumlah_peserta
            : ($this->jumlah_kepala_sekolah + $this->jumlah_guru);

        return $this->activity->registration_fee * $totalPeserta;
    }
}

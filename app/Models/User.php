<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Boot method untuk model User.
     * Menambahkan proteksi saat deleting user.
     */
    protected static function boot()
    {
        parent::boot();

        // Event: BEFORE soft delete
        static::deleting(function ($user) {
            // Log aktivitas delete untuk audit trail
            \Log::info('User soft delete initiated', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'user_email' => $user->email,
                'npsn' => $user->npsn
            ]);

            // Jika role sekolah, cek apakah ada peserta terkait
            if ($user->role === 'sekolah' && $user->npsn) {
                $relatedPeserta = self::where('role', 'peserta')
                    ->where('npsn', $user->npsn)
                    ->whereNull('deleted_at')
                    ->count();

                if ($relatedPeserta > 0) {
                    \Log::warning('Deleting sekolah with related active peserta', [
                        'sekolah_id' => $user->id,
                        'sekolah_name' => $user->name,
                        'npsn' => $user->npsn,
                        'related_peserta_count' => $relatedPeserta
                    ]);
                }
            }
        });

        // Event: BEFORE force delete (permanent delete)
        static::forceDeleting(function ($user) {
            // Cegah force delete jika user adalah sekolah dengan peserta aktif
            if ($user->role === 'sekolah' && $user->npsn) {
                $relatedPeserta = self::where('role', 'peserta')
                    ->where('npsn', $user->npsn)
                    ->whereNull('deleted_at')
                    ->count();

                if ($relatedPeserta > 0) {
                    \Log::error('PREVENTED: Attempted force delete of sekolah with active peserta', [
                        'sekolah_id' => $user->id,
                        'sekolah_name' => $user->name,
                        'npsn' => $user->npsn,
                        'related_peserta_count' => $relatedPeserta
                    ]);

                    // Lempar exception untuk mencegah force delete
                    throw new \Exception("Tidak dapat menghapus permanen akun sekolah yang memiliki {$relatedPeserta} peserta aktif. Hapus atau pindahkan peserta terlebih dahulu.");
                }
            }

            \Log::warning('User PERMANENT DELETE (force delete)', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'user_email' => $user->email
            ]);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'degree',
        'email',
        'email_belajar',
        'password',
        'role',
        'phone',
        'no_hp',
        'address',
        'province',
        'city',
        'kecamatan',
        'district',
        'institution',
        'instansi',
        'position',
        'position_type',
        'jabatan',
        'gelar',
        'status',
        'npsn',
        'nip',
        'nip_nipy',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'jenis_kelamin',
        'pns_status',
        'rank',
        'pangkat',
        'group',
        'golongan',
        'last_education',
        'pendidikan_terakhir',
        'major',
        'jurusan',
        'photo',
        'foto_3x4',
        'digital_signature',
        'tanda_tangan',
        'surat_tugas',
        'google_id',
        'avatar',
        'email_belajar_id',
        'alamat_sekolah',
        'alamat_lengkap',
        'kcd',
        'nama_sekolah',
        'nama_kepala_sekolah',
        'email_belajar_sekolah',
        'no_wa',
        'nama_pendaftar',
        'jabatan_pendaftar',
        'sk_pendaftar_path',
        'approval_status',
        'approved_at',
        'approved_by',
        'provinsi',
        'kabupaten',
        'kabupaten_kota',
        'pendaftar',
        'sk_pendaftar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function createdPrograms()
    {
        return $this->hasMany(Program::class, 'created_by');
    }

    public function createdActivities()
    {
        return $this->hasMany(Activity::class, 'created_by');
    }

    public function createdClasses()
    {
        return $this->hasMany(Classes::class, 'created_by');
    }

    public function adminMappings()
    {
        return $this->hasMany(AdminMapping::class, 'admin_id');
    }

    public function fasilitatorMappings()
    {
        return $this->hasMany(FasilitatorMapping::class, 'fasilitator_id');
    }

    public function participantMappings()
    {
        return $this->hasMany(ParticipantMapping::class, 'participant_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'user_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'participant_id');
    }

    public function givenGrades()
    {
        return $this->hasMany(Grade::class, 'fasilitator_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'created_by');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper methods
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFasilitator()
    {
        return $this->role === 'fasilitator';
    }

    public function isPeserta()
    {
        return $this->role === 'peserta';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isSekolah()
    {
        return $this->role === 'sekolah';
    }

    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    public function isPending()
    {
        return $this->approval_status === 'pending';
    }
}

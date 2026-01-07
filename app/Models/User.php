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
        'address',
        'institution',
        'position',
        'position_type',
        'status',
        'npsn',
        'nip',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'pns_status',
        'rank',
        'group',
        'last_education',
        'major',
        'photo',
        'digital_signature',
        'google_id',
        'avatar',
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
}

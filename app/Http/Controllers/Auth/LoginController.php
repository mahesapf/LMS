<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\TeacherParticipant;
use App\Models\Registration;
use App\Models\ParticipantMapping;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Sync user with teacher_participants and registrations
        $this->syncUserWithParticipants($user);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Sync user with teacher participants and create participant mappings
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function syncUserWithParticipants($user)
    {
        // Sync teacher_participants by email or NIK
        $teachers = TeacherParticipant::where(function($query) use ($user) {
            $query->where('email', $user->email)
                  ->orWhere('nik', $user->nik);
        })->whereNull('user_id')->get();

        foreach ($teachers as $teacher) {
            $teacher->update(['user_id' => $user->id]);

            // Update user with location data from registration if available
            if ($teacher->registration && !$user->province) {
                $user->update([
                    'province' => $teacher->registration->provinsi,
                    'city' => $teacher->registration->kab_kota,
                    'district' => $teacher->registration->kecamatan,
                    'instansi' => $teacher->registration->nama_sekolah,
                    'alamat_sekolah' => $teacher->registration->alamat_sekolah,
                ]);
            }

            // Create participant mapping if teacher's registration is assigned to a class
            if ($teacher->registration && $teacher->registration->class_id) {
                $exists = ParticipantMapping::where('class_id', $teacher->registration->class_id)
                    ->where('participant_id', $user->id)
                    ->exists();

                if (!$exists) {
                    ParticipantMapping::create([
                        'class_id' => $teacher->registration->class_id,
                        'participant_id' => $user->id,
                        'enrolled_date' => now(),
                        'assigned_by' => 1, // System assigned
                        'status' => 'in',
                    ]);
                }
            }
        }

        // Sync kepala sekolah by email or NIK
        $registrations = Registration::where(function($query) use ($user) {
            $query->where('email', $user->email)
                  ->orWhere('nik_kepala_sekolah', $user->nik);
        })->whereNull('kepala_sekolah_user_id')
          ->where('jumlah_kepala_sekolah', '>', 0)
          ->get();

        foreach ($registrations as $registration) {
            $registration->update(['kepala_sekolah_user_id' => $user->id]);

            // Update user with location data from registration if available
            if (!$user->province) {
                $user->update([
                    'province' => $registration->provinsi,
                    'city' => $registration->kab_kota,
                    'district' => $registration->kecamatan,
                    'instansi' => $registration->nama_sekolah,
                    'alamat_sekolah' => $registration->alamat_sekolah,
                ]);
            }

            // Create participant mapping if registration is assigned to a class
            if ($registration->class_id) {
                $exists = ParticipantMapping::where('class_id', $registration->class_id)
                    ->where('participant_id', $user->id)
                    ->exists();

                if (!$exists) {
                    ParticipantMapping::create([
                        'class_id' => $registration->class_id,
                        'participant_id' => $user->id,
                        'enrolled_date' => now(),
                        'assigned_by' => 1, // System assigned
                        'status' => 'in',
                    ]);
                }
            }
        }
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = auth()->user();

        return match($user->role) {
            'super_admin' => route('super-admin.dashboard'),
            'admin' => route('admin.dashboard'),
            'fasilitator' => route('fasilitator.dashboard'),
            'peserta' => route('peserta.dashboard'),
            default => route('home'),
        };
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}

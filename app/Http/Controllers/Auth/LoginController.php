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
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        $login = request()->input('email');

        // Check if the login input is NPSN (numeric)
        if (is_numeric($login)) {
            return 'npsn';
        }

        return 'email';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $login = $request->input('email');
        $loginType = is_numeric($login) ? 'NPSN' : 'Email';

        $request->validate([
            'email' => 'required|string|max:100',
            'password' => 'required|string|min:8|max:255',
        ], [
            'email.required' => 'Email atau NPSN harus diisi',
            'email.max' => 'Email atau NPSN maksimal 100 karakter',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 255 karakter',
        ]);

        // Set custom message for failed login attempt
        $this->loginType = $loginType;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $login = $request->input('email');
        $field = is_numeric($login) ? 'npsn' : 'email';

        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }

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
        // Sync user with teacher_participants and registrations (only for peserta role)
        if ($user->role === 'peserta') {
            $this->syncUserWithParticipants($user);
        }

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
        // Sync teacher_participants by email only
        $teachers = TeacherParticipant::where('email', $user->email)
            ->whereNull('user_id')
            ->get();

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
                    // Get system admin (super_admin or first admin) for auto-assignment
                    $systemAdmin = \App\Models\User::whereIn('role', ['super_admin', 'admin'])
                        ->orderBy('id')
                        ->first();
                    
                    ParticipantMapping::create([
                        'class_id' => $teacher->registration->class_id,
                        'participant_id' => $user->id,
                        'enrolled_date' => now(),
                        'assigned_by' => $systemAdmin ? $systemAdmin->id : 1, // System assigned
                        'status' => 'in',
                    ]);
                }
            }
        }

        // Sync kepala sekolah by NIK (kepala sekolah doesn't have separate email in registration)
        $registrations = Registration::where('nik_kepala_sekolah', $user->nik)
          ->whereNull('kepala_sekolah_user_id')
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
                    // Get system admin (super_admin or first admin) for auto-assignment
                    $systemAdmin = \App\Models\User::whereIn('role', ['super_admin', 'admin'])
                        ->orderBy('id')
                        ->first();
                    
                    ParticipantMapping::create([
                        'class_id' => $registration->class_id,
                        'participant_id' => $user->id,
                        'enrolled_date' => now(),
                        'assigned_by' => $systemAdmin ? $systemAdmin->id : 1, // System assigned
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
            'sekolah' => route('sekolah.dashboard'),
            default => route('home'),
        };
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $login = $request->input('email');
        $loginType = is_numeric($login) ? 'NPSN' : 'Email';

        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => ["Login gagal! {$loginType} atau password yang Anda masukkan salah. Pastikan Anda menggunakan kredensial yang benar."],
        ]);
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

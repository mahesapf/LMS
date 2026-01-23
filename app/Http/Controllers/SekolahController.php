<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Registration;

class SekolahController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkSekolahApproved']);
    }

    /**
     * Display sekolah dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'total_registrations' => Registration::where('user_id', $user->id)->count(),
            'pending_registrations' => Registration::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'approved_registrations' => Registration::where('user_id', $user->id)
                ->where('status', 'approved')
                ->count(),
            'available_activities' => Activity::whereIn('status', ['planned', 'ongoing'])->count(),
        ];

        $recentRegistrations = Registration::where('user_id', $user->id)
            ->with('activity.program')
            ->latest()
            ->take(5)
            ->get();

        // Get activities grouped by date for calendar
        $activitiesByDate = Registration::where('user_id', $user->id)
            ->with('activity')
            ->get()
            ->groupBy(function($registration) {
                return $registration->activity->start_date->format('Y-m-d');
            })
            ->map(function($registrations) {
                return $registrations->map(function($registration) {
                    return [
                        'name' => $registration->activity->name,
                        'status' => $registration->status
                    ];
                });
            });

        return view('sekolah.dashboard', compact('stats', 'recentRegistrations', 'activitiesByDate'));
    }

    /**
     * Display sekolah profile.
     */
    public function profile()
    {
        $user = auth()->user();

        return view('sekolah.profile', compact('user'));
    }

    /**
     * Update sekolah profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama_kepala_sekolah' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'pendaftar' => 'required|string|max:255',
            'jabatan_pendaftar' => 'required|string|max:50|in:Wakasek Kurikulum,Wakasek Humas Hubin,Lainnya',
            'kabupaten' => 'required|string|max:255',
        ]);

        // Update dengan menyimpan ke semua field yang relevan
        $user->update([
            'nama_kepala_sekolah' => $validated['nama_kepala_sekolah'],
            'no_wa' => $validated['no_wa'],
            'no_hp' => $validated['no_wa'], // Sync ke no_hp juga
            'pendaftar' => $validated['pendaftar'],
            'nama_pendaftar' => $validated['pendaftar'], // Sync ke nama_pendaftar juga
            'jabatan_pendaftar' => $validated['jabatan_pendaftar'],
            'kabupaten' => $validated['kabupaten'],
            'kabupaten_kota' => $validated['kabupaten'], // Sync ke kabupaten_kota juga
            'city' => $validated['kabupaten'], // Sync ke city juga
        ]);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
    }

    /**
     * Display sekolah registrations.
     */
    public function registrations()
    {
        $registrations = Registration::where('user_id', auth()->id())
            ->with(['activity.program', 'payment'])
            ->latest()
            ->paginate(10);

        return view('sekolah.registrations', compact('registrations'));
    }

    public function accountInfo()
    {
        $user = auth()->user()->load('approvedByUser');

        // Get all active peserta accounts with same NPSN as logged in sekolah
        $activePesertaAccounts = \App\Models\User::where('role', 'peserta')
            ->where('status', 'active')
            ->where('npsn', $user->npsn)
            ->whereNotNull('npsn')
            ->orderBy('approved_at', 'desc')
            ->get();

        return view('sekolah.account-info', compact('user', 'activePesertaAccounts'));
    }

    /**
     * Display sekolah activities page.
     */
    public function activities()
    {
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])
            ->with('program')
            ->orderBy('start_date')
            ->get();

        $myRegistrations = Registration::where('user_id', auth()->id())
            ->with(['activity.program', 'payment', 'teacherParticipants'])
            ->latest()
            ->get();

        return view('sekolah.activities.index', compact('activities', 'myRegistrations'));
    }
}

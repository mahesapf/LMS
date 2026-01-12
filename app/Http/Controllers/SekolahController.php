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

        return view('sekolah.dashboard', compact('stats', 'recentRegistrations'));
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
            'kabupaten' => 'required|string|max:255',
        ]);

        $user->update($validated);

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
}

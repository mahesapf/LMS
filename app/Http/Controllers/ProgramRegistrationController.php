<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Registration;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActivityRegistrationController extends Controller
{
    /**
     * Display a listing of available activities.
     */
    public function index()
    {
        $activities = Activity::where('status', 'active')
            ->whereDate('start_date', '>', now())
            ->with('program')
            ->orderBy('start_date')
            ->get();

        $myRegistrations = Registration::where('user_id', Auth::id())
            ->with(['activity.program', 'payment'])
            ->get();

        return view('peserta.activities.index', compact('activities', 'myRegistrations'));
    }

    /**
     * Show the form for creating a new registration.
     */
    public function show(Activity $activity)
    {
        // Check if user already registered
        $existingRegistration = Registration::where('activity_id', $activity->id)
            ->where('user_id', Auth::id())
            ->first();

        return view('peserta.activities.show', compact('activity', 'existingRegistration'));
    }

    /**
     * Store a newly created registration.
     */
    public function register(Request $request, Activity $activity)
    {
        // Check if already registered
        $existingRegistration = Registration::where('activity_id', $activity->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRegistration) {
            return redirect()->route('peserta.activities.show', $activity)
                ->with('error', 'Anda sudah terdaftar pada kegiatan ini.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'position' => 'required|in:Kepala Sekolah,Guru',
            'school_name' => 'required|string|max:255',
        ]);

        $registration = Registration::create([
            'activity_id' => $activity->id,
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'position' => $validated['position'],
            'school_name' => $validated['school_name'],
            'status' => 'payment_pending',
        ]);

        return redirect()->route('peserta.payment.create', $registration)
            ->with('success', 'Pendaftaran berhasil! Silakan lanjutkan ke pembayaran.');
    }

    /**
     * Show payment form.
     */
    public function createPayment(Registration $registration)
    {
        // Check ownership
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if already paid
        if ($registration->payment) {
            return redirect()->route('peserta.programs.index')
                ->with('info', 'Anda sudah melakukan pembayaran untuk program ini.');
        }

        return view('peserta.payment.create', compact('registration'));
    }

    /**
     * Store payment information.
     */
    public function storePayment(Request $request, Registration $registration)
    {
        // Check ownership
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        // Check payment deadline (1 week before activity starts)
        $paymentDeadline = $registration->activity->start_date->subWeek();
        if (now()->greaterThan($paymentDeadline)) {
            return back()->with('error', 'Batas waktu pembayaran telah lewat.');
        }

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date|before_or_equal:today',
            'proof_file' => 'required|image|max:2048',
        ]);

        // Upload proof file
        $proofPath = $request->file('proof_file')->store('payment-proofs', 'public');

        Payment::create([
            'registration_id' => $registration->id,
            'bank_name' => $validated['bank_name'],
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'proof_file' => $proofPath,
            'status' => 'pending',
        ]);

        // Update registration status
        $registration->update(['status' => 'payment_uploaded']);

        return redirect()->route('peserta.activities.index')
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu validasi super admin.');
    }
}

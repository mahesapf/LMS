<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\TeacherParticipant;
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
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])
            ->with('program')
            ->orderBy('start_date')
            ->get();

        // Only get registrations if user is logged in
        $myRegistrations = Auth::check()
            ? Registration::where('user_id', Auth::id())
                ->with(['activity.program', 'payment'])
                ->get()
            : collect();

        return view('activities.index', compact('activities', 'myRegistrations'));
    }

    /**
     * Show the form for creating a new registration.
     */
    public function show(Activity $activity)
    {
        // Check if user already registered (only if logged in)
        $existingRegistration = Auth::check()
            ? Registration::where('activity_id', $activity->id)
                ->where('user_id', Auth::id())
                ->first()
            : null;

        return view('activities.show', compact('activity', 'existingRegistration'));
    }

    /**
     * Show registration form.
     */
    public function showRegisterForm(Activity $activity)
    {
        // Require login for registration
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu untuk mendaftar kegiatan.');
        }

        // Check if already registered
        $existingRegistration = Registration::where('activity_id', $activity->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRegistration) {
            return redirect()->route('activities.show', $activity)
                ->with('info', 'Anda sudah terdaftar pada kegiatan ini.');
        }

        return view('activities.register', compact('activity'));
    }

    /**
     * Store a newly created registration.
     */
    public function register(Request $request, Activity $activity)
    {
        // Require login for registration
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu untuk mendaftar kegiatan.');
        }

        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string',
            'provinsi' => 'required|string|max:255',
            'kab_kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kcd' => 'required|string|max:255',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'nik_kepala_sekolah' => 'required|string|size:16|regex:/^[0-9]{16}$/',
            'jumlah_peserta' => 'required|integer|min:0',
            'jumlah_kepala_sekolah' => 'required|integer|min:0',
            'jumlah_guru' => 'required|integer|min:0',
        ]);

        $registration = Registration::create([
            'activity_id' => $activity->id,
            'user_id' => Auth::id(),
            'name' => $validated['nama_kepala_sekolah'], // Use kepala sekolah name as main name
            'phone' => $request->nomor_telp ?? '', // Optional phone
            'email' => $request->email ?? '', // Optional email
            'position' => 'Kepala Sekolah',
            'nama_sekolah' => $validated['nama_sekolah'],
            'alamat_sekolah' => $validated['alamat_sekolah'],
            'provinsi' => $validated['provinsi'],
            'kab_kota' => $validated['kab_kota'],
            'kecamatan' => $validated['kecamatan'],
            'kcd' => $validated['kcd'],
            'nama_kepala_sekolah' => $validated['nama_kepala_sekolah'],
            'nik_kepala_sekolah' => $validated['nik_kepala_sekolah'],
            'nomor_telp' => $request->nomor_telp ?? null,
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'jumlah_kepala_sekolah' => $validated['jumlah_kepala_sekolah'],
            'jumlah_guru' => $validated['jumlah_guru'],
            'status' => 'pending',
        ]);

        $totalPeserta = $validated['jumlah_peserta'] > 0
            ? $validated['jumlah_peserta']
            : ($validated['jumlah_kepala_sekolah'] + $validated['jumlah_guru']);

        // Calculate total payment
        $totalBiaya = $registration->calculateTotalPayment();

        $message = "Pendaftaran sekolah {$validated['nama_sekolah']} berhasil! Total {$totalPeserta} peserta terdaftar.";

        if ($totalBiaya > 0) {
            $message .= " Total pembayaran: Rp " . number_format($totalBiaya, 0, ',', '.') . ". ";
            $message .= "Silakan lakukan pembayaran untuk menyelesaikan pendaftaran.";

            // Redirect to payment page if there's a fee
            return redirect()->route('payment.create', $registration)
                ->with('success', $message);
        }

        return redirect()->route('activities.index')
            ->with('success', $message . " Terima kasih!");
    }

    /**
     * Show payment form.
     */
    public function createPayment(Registration $registration)
    {
        // Require login for payment
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu untuk melakukan pembayaran.');
        }

        // Check ownership
        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke registrasi ini.');
        }

        // Check if already paid
        if ($registration->payment) {
            return redirect()->route('activities.index')
                ->with('info', 'Sekolah ini sudah melakukan pembayaran.');
        }

        return view('payment.create', compact('registration'));
    }

    /**
     * Store payment information.
     */
    public function storePayment(Request $request, Registration $registration)
    {
        // Check ownership only if user is logged in
        if (Auth::check() && $registration->user_id !== Auth::id()) {
            abort(403);
        }

        // For public registration (no user_id), allow access
        if (!Auth::check() && $registration->user_id !== null) {
            abort(403, 'Anda harus login untuk mengakses halaman ini.');
        }

        // Check payment deadline (1 week before activity starts)
        $paymentDeadline = $registration->activity->start_date->subWeek();
        if (now()->greaterThan($paymentDeadline)) {
            return back()->with('error', 'Batas waktu pembayaran telah lewat.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date|before_or_equal:today',
            'proof_file' => 'required|image|max:2048',
            'contact_number' => 'required|string|max:20',
            'surat_tugas_kepala_sekolah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'teachers' => 'nullable|array',
            'teachers.*.nama_lengkap' => 'required|string|max:255',
            'teachers.*.nip' => 'nullable|string|max:50',
            'teachers.*.nik' => 'nullable|string|size:16|regex:/^[0-9]{16}$/',
            'teachers.*.email' => 'nullable|email|max:255',
            'teachers.*.surat_tugas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Upload proof file
        $proofPath = $request->file('proof_file')->store('payment-proofs', 'public');

        // Upload surat tugas kepala sekolah if exists
        $suratTugasKepalaSekolahPath = null;
        if ($request->hasFile('surat_tugas_kepala_sekolah')) {
            $suratTugasKepalaSekolahPath = $request->file('surat_tugas_kepala_sekolah')->store('surat-tugas-kepala-sekolah', 'public');

            // Update registration with surat tugas kepala sekolah
            $registration->update([
                'surat_tugas_kepala_sekolah' => $suratTugasKepalaSekolahPath
            ]);
        }

        $payment = Payment::create([
            'registration_id' => $registration->id,
            'bank_name' => 'Transfer Bank', // Default value
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'proof_file' => $proofPath,
            'contact_number' => $validated['contact_number'],
            'status' => 'pending',
        ]);

        // Save teacher participants data
        if ($request->has('teachers')) {
            foreach ($request->teachers as $teacherData) {
                $suratTugasPath = null;
                if (isset($teacherData['surat_tugas'])) {
                    $suratTugasPath = $teacherData['surat_tugas']->store('surat-tugas', 'public');
                }

                TeacherParticipant::create([
                    'registration_id' => $registration->id,
                    'nama_lengkap' => $teacherData['nama_lengkap'],
                    'nip' => $teacherData['nip'] ?? null,
                    'nik' => $teacherData['nik'] ?? null,
                    'email' => $teacherData['email'] ?? null,
                    'surat_tugas' => $suratTugasPath,
                ]);
            }
        }

        // Update registration status
        $registration->update(['status' => 'payment_uploaded']);

        return redirect()->route('activities.index')
            ->with('success', 'Bukti pembayaran untuk ' . $registration->nama_sekolah . ' berhasil diupload. Menunggu validasi admin.');
    }
}

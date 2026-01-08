<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentValidationController extends Controller
{
    /**
     * Display a listing of payments to validate.
     */
    public function index(Request $request)
    {
        $payments = Payment::with(['registration.activity.program', 'registration.user', 'registration.teacherParticipants'])
            ->whereIn('status', ['pending'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Query for validated payments with optional activity filter
        $validatedPaymentsQuery = Payment::with(['registration.activity.program', 'registration.user', 'registration.teacherParticipants', 'validator'])
            ->where('status', 'validated')
            ->orderBy('validated_at', 'desc');

        // Apply activity filter if provided
        if ($request->filled('activity_id')) {
            $validatedPaymentsQuery->whereHas('registration', function($q) use ($request) {
                $q->where('activity_id', $request->activity_id);
            });
        }

        $validatedPayments = $validatedPaymentsQuery->paginate(20)->appends($request->only('activity_id'));

        // Get all activities for filter dropdown
        $activities = \App\Models\Activity::with('program')
            ->orderBy('name')
            ->get();

        return view('admin.payments.index', compact('payments', 'validatedPayments', 'activities'));
    }

    /**
     * Show the payment details.
     */
    public function show(Payment $payment)
    {
        $payment->load(['registration.activity.program', 'registration.user']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Approve the payment (Super Admin only).
     */
    public function approve(Payment $payment)
    {
        $payment->update([
            'status' => 'validated',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        $payment->registration->update([
            'status' => 'validated'
        ]);

        // Update user role to peserta only if user exists (logged-in registration)
        $user = $payment->registration->user;
        if ($user && $user->role !== 'peserta') {
            $user->update(['role' => 'peserta']);
        }

        $schoolName = $payment->registration->nama_sekolah;
        $message = "Pembayaran untuk {$schoolName} berhasil divalidasi.";
        
        if ($user) {
            $message .= " User sekarang menjadi peserta.";
        }

        return redirect()->route('super-admin.payments.index')
            ->with('success', $message);
    }

    /**
     * Reject the payment (Super Admin only).
     */
    public function reject(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $payment->update([
            'status' => 'rejected',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        $payment->registration->update([
            'status' => 'rejected'
        ]);

        return redirect()->route('super-admin.payments.index')
            ->with('success', 'Pembayaran ditolak.');
    }

    /**
     * Export participants data based on filter.
     */
    public function exportParticipants(Request $request)
    {
        // Query for validated payments with optional activity filter
        $query = Payment::with(['registration.activity.program', 'registration.teacherParticipants', 'validator'])
            ->where('status', 'validated')
            ->orderBy('validated_at', 'desc');

        // Apply activity filter if provided
        if ($request->filled('activity_id')) {
            $query->whereHas('registration', function($q) use ($request) {
                $q->where('activity_id', $request->activity_id);
            });
        }

        $payments = $query->get();

        // Generate CSV
        $filename = 'data_peserta_' . date('Y-m-d_His') . '.csv';
        
        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers - Updated to NIK
            fputcsv($file, [
                'Nama Lengkap',
                'NIK',
                'Email'
            ]);

            foreach ($payments as $payment) {
                $registration = $payment->registration;
                
                // Export Kepala Sekolah if exists
                if ($registration->jumlah_kepala_sekolah > 0) {
                    fputcsv($file, [
                        $registration->kepala_sekolah,
                        $registration->nik_kepala_sekolah ?? '-',
                        $registration->email ?? '-'
                    ]);
                }

                // Export Teachers
                foreach ($registration->teacherParticipants as $teacher) {
                    fputcsv($file, [
                        $teacher->nama_lengkap,
                        $teacher->nik ?? '-',
                        $teacher->email ?? '-'
                    ]);
                }
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}

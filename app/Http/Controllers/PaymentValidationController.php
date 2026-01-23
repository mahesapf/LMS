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

        $user = $payment->registration->user;
        // Jangan ubah role sekolah menjadi peserta
        if ($user && $user->role !== 'peserta' && $user->role !== 'sekolah') {
            $user->update(['role' => 'peserta']);
        }

        if ($user) {
            $updates = [];
            $registration = $payment->registration;

            if (empty($user->instansi) && !empty($registration->nama_sekolah)) {
                $updates['instansi'] = $registration->nama_sekolah;
            }

            if (empty($user->alamat_sekolah) && !empty($registration->alamat_sekolah)) {
                $updates['alamat_sekolah'] = $registration->alamat_sekolah;
            }

            if (!empty($updates)) {
                $user->update($updates);
            }
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
                        $registration->nama_kepala_sekolah,
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

    /**
     * Export single payment validation data.
     */
    public function exportSinglePayment(Payment $payment)
    {
        $registration = $payment->registration;
        $schoolName = str_replace(' ', '_', $registration->nama_sekolah);
        $filename = 'validasi_pembayaran_' . $schoolName . '_' . date('Y-m-d_His') . '.csv';

        $callback = function() use ($payment, $registration) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Payment Info Section
            fputcsv($file, ['INFORMASI PEMBAYARAN']);
            fputcsv($file, ['Sekolah', $registration->nama_sekolah]);
            fputcsv($file, ['Alamat', $registration->alamat_sekolah]);
            fputcsv($file, ['Provinsi', $registration->provinsi]);
            fputcsv($file, ['Kab/Kota', $registration->kab_kota]);
            fputcsv($file, ['Kecamatan', $registration->kecamatan ?? '-']);
            fputcsv($file, ['KCD', $registration->kcd ?? '-']);
            fputcsv($file, ['']);

            fputcsv($file, ['Kegiatan', $registration->activity->name]);
            fputcsv($file, ['Program', $registration->activity->program->name ?? '-']);
            fputcsv($file, ['']);

            fputcsv($file, ['Jumlah Pembayaran', 'Rp ' . number_format($payment->amount, 0, ',', '.')]);
            fputcsv($file, ['Tanggal Transfer', \Carbon\Carbon::parse($payment->payment_date)->format('d M Y')]);
            fputcsv($file, ['Status', 'Tervalidasi']);
            fputcsv($file, ['Validator', $payment->validator->name ?? '-']);
            fputcsv($file, ['Tanggal Validasi', $payment->validated_at ? $payment->validated_at->format('d M Y H:i') : '-']);
            fputcsv($file, ['']);
            fputcsv($file, ['']);

            // Participants Section
            fputcsv($file, ['DAFTAR PESERTA']);
            fputcsv($file, ['Nama Lengkap', 'Jabatan', 'NIK', 'Email']);

            // Export Kepala Sekolah if exists
            if ($registration->jumlah_kepala_sekolah > 0) {
                fputcsv($file, [
                    $registration->nama_kepala_sekolah,
                    'Kepala Sekolah',
                    $registration->nik_kepala_sekolah ?? '-',
                    $registration->email ?? '-'
                ]);
            }

            // Export Teachers
            foreach ($registration->teacherParticipants as $teacher) {
                fputcsv($file, [
                    $teacher->nama_lengkap,
                    'Guru',
                    $teacher->nik ?? '-',
                    $teacher->email ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Delete payment (Super Admin only).
     */
    public function destroy(Payment $payment)
    {
        // Update registration status back to pending or appropriate status
        $registration = $payment->registration;
        if ($registration) {
            $registration->update([
                'status' => 'pending'
            ]);
        }

        // Soft delete the payment
        $payment->delete();

        return redirect()->route('super-admin.payments.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }

    /**
     * Export selected payments data.
     */
    public function exportSelected(Request $request)
    {
        $request->validate([
            'school_ids' => 'required|array',
            'school_ids.*' => 'exists:payments,id',
        ]);

        $payments = Payment::with(['registration.activity.program', 'registration.teacherParticipants', 'validator'])
            ->whereIn('id', $request->school_ids)
            ->where('status', 'validated')
            ->orderBy('validated_at', 'desc')
            ->get();

        $filename = 'data_peserta_selected_' . count($request->school_ids) . '_payments_' . date('Y-m-d_His') . '.csv';

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
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
                        $registration->nama_kepala_sekolah,
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

    /**
     * Export payments by selected schools.
     */
    public function exportBySchools(Request $request)
    {
        $request->validate([
            'school_ids' => 'required|array',
            'school_ids.*' => 'exists:payments,id',
        ]);

        $payments = Payment::with(['registration.activity.program', 'registration.teacherParticipants', 'validator'])
            ->whereIn('id', $request->school_ids)
            ->where('status', 'validated')
            ->orderBy('validated_at', 'desc')
            ->get();

        $filename = 'validasi_pembayaran_' . count($request->school_ids) . '_sekolah_' . date('Y-m-d_His') . '.csv';

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Nama Lengkap',
                'NIK',
                'Email'
            ]);

            foreach ($payments as $payment) {
                $registration = $payment->registration;

                // Export all participants (Kepala Sekolah dan Guru from teacherParticipants table)
                foreach ($registration->teacherParticipants as $participant) {
                    fputcsv($file, [
                        $participant->nama_lengkap,
                        $participant->nik ?? '-',
                        $participant->email ?? '-'
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

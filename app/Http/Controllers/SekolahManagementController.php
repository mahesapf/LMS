<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SekolahApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SekolahManagementController extends Controller
{
    /**
     * Display a listing of sekolah registrations.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = User::where('role', 'sekolah');

        // Admin hanya bisa melihat sekolah yang sudah approved
        if (auth()->user()->role === 'admin') {
            $query->where('status', 'active');
        } elseif ($status !== 'all') {
            // Map status filter to user status (untuk super-admin)
            // pending = inactive, approved = active, rejected = suspended
            if ($status === 'pending') {
                $query->where('status', 'inactive');
            } elseif ($status === 'approved') {
                $query->where('status', 'active');
            } elseif ($status === 'rejected') {
                $query->where('status', 'suspended');
            }
        }

        $sekolahs = $query->latest()->paginate(20);

        // Gunakan view berbeda untuk admin dan super-admin
        if (auth()->user()->role === 'admin') {
            return view('admin.sekolah.index', compact('sekolahs', 'status'));
        }
        return view('super-admin.sekolah.index', compact('sekolahs', 'status'));
    }

    /**
     * Display the specified sekolah.
     */
    public function show($id)
    {
        $sekolah = User::where('role', 'sekolah')->findOrFail($id);

        // Gunakan view berbeda untuk admin dan super-admin
        if (auth()->user()->role === 'admin') {
            return view('admin.sekolah.show', compact('sekolah'));
        }
        return view('super-admin.sekolah.show', compact('sekolah'));
    }

    /**
     * Approve sekolah registration.
     */
    public function approve($id)
    {
        try {
            $sekolah = User::where('role', 'sekolah')->findOrFail($id);

            // Check if already approved
            if ($sekolah->status === 'active') {
                return redirect()->back()->with('info', 'Akun sekolah sudah disetujui sebelumnya.');
            }

            $sekolah->update([
                'status' => 'active',
            ]);

            // Send approval email
            try {
                // Use email or email_belajar
                $emailTo = $sekolah->email_belajar ?: $sekolah->email;
                if ($emailTo) {
                    Mail::to($emailTo)->send(new SekolahApproved($sekolah));
                }
            } catch (\Exception $e) {
                // Log email error but don't fail the approval
                \Log::error('Failed to send approval email: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Akun sekolah berhasil disetujui dan email notifikasi telah dikirim.');

        } catch (\Exception $e) {
            \Log::error('Error approving sekolah: ' . $e->getMessage(), [
                'sekolah_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui akun sekolah: ' . $e->getMessage());
        }
    }

    /**
     * Reject sekolah registration.
     */
    public function reject(Request $request, $id)
    {
        try {
            $sekolah = User::where('role', 'sekolah')
                ->findOrFail($id);

            // Check if already rejected/suspended
            if ($sekolah->status === 'suspended') {
                return redirect()->back()->with('info', 'Akun sekolah sudah ditolak/suspend sebelumnya.');
            }

            $sekolah->update([
                'status' => 'suspended',
            ]);

            $message = $sekolah->status === 'inactive'
                ? 'Pendaftaran sekolah berhasil ditolak.'
                : 'Akun sekolah berhasil di-suspend.';

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak/suspend sekolah.');
        }
    }

    /**
     * Download SK Pendaftar file.
     */
    public function downloadSK($id)
    {
        $sekolah = User::where('role', 'sekolah')->findOrFail($id);

        $skPathValue = $sekolah->sk_pendaftar ?: $sekolah->sk_pendaftar_path;

        if (!$skPathValue) {
            abort(404, 'File SK tidak ditemukan.');
        }

        $filePath = str_starts_with($skPathValue, 'public/')
            ? $skPathValue
            : 'public/' . $skPathValue;

        if (!Storage::exists($filePath)) {
            abort(404, 'File SK tidak ditemukan.');
        }

        return Storage::download($filePath);
    }

    /**
     * Delete sekolah account.
     * Note: This is a SOFT DELETE - sekolah record is not permanently deleted,
     * just marked with deleted_at timestamp. Related peserta accounts are NOT deleted.
     */
    public function destroy($id)
    {
        try {
            $sekolah = User::where('role', 'sekolah')->findOrFail($id);

            // Check if there are related peserta accounts with the same NPSN
            $relatedPeserta = User::where('role', 'peserta')
                ->where('npsn', $sekolah->npsn)
                ->whereNotNull('npsn')
                ->count();

            if ($relatedPeserta > 0) {
                // Warn admin about related peserta accounts
                \Log::warning('Deleting sekolah with related peserta accounts', [
                    'sekolah_id' => $sekolah->id,
                    'sekolah_name' => $sekolah->name,
                    'npsn' => $sekolah->npsn,
                    'related_peserta_count' => $relatedPeserta
                ]);
            }

            // Soft delete the sekolah account only (peserta are NOT affected)
            // This sets deleted_at timestamp but keeps the record in database
            $sekolah->delete();

            $message = 'Akun sekolah berhasil dihapus.';
            if ($relatedPeserta > 0) {
                $message .= " Terdapat {$relatedPeserta} akun peserta dengan NPSN yang sama yang TIDAK ikut terhapus.";
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Error deleting sekolah: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus akun sekolah.');
        }
    }
}

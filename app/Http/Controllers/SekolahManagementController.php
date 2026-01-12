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

        if ($status !== 'all') {
            $query->where('approval_status', $status);
        }

        $sekolahs = $query->latest()->paginate(20);

        return view('super-admin.sekolah.index', compact('sekolahs', 'status'));
    }

    /**
     * Display the specified sekolah.
     */
    public function show($id)
    {
        $sekolah = User::where('role', 'sekolah')->findOrFail($id);

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
            if ($sekolah->approval_status === 'approved') {
                return redirect()->back()->with('info', 'Akun sekolah sudah disetujui sebelumnya.');
            }

            $sekolah->update([
                'approval_status' => 'approved',
                'status' => 'active',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            // Send approval email
            try {
                // Use email or email_belajar_sekolah
                $emailTo = $sekolah->email_belajar_sekolah ?: $sekolah->email;
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
                ->where('approval_status', 'pending')
                ->findOrFail($id);

            $sekolah->update([
                'approval_status' => 'rejected',
                'approved_by' => auth()->id(),
            ]);

            return redirect()->back()->with('success', 'Pendaftaran sekolah berhasil ditolak.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak pendaftaran sekolah.');
        }
    }

    /**
     * Download SK Pendaftar file.
     */
    public function downloadSK($id)
    {
        $sekolah = User::where('role', 'sekolah')->findOrFail($id);

        if (!$sekolah->sk_pendaftar) {
            abort(404, 'File SK tidak ditemukan.');
        }

        $filePath = 'public/' . $sekolah->sk_pendaftar;

        if (!Storage::exists($filePath)) {
            abort(404, 'File SK tidak ditemukan.');
        }

        return Storage::download($filePath);
    }

    /**
     * Delete sekolah account.
     */
    public function destroy($id)
    {
        try {
            $sekolah = User::where('role', 'sekolah')->findOrFail($id);

            // Delete SK file if exists
            if ($sekolah->sk_pendaftar) {
                $filePath = 'public/' . $sekolah->sk_pendaftar;
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }

            $sekolah->delete();

            return redirect()->back()->with('success', 'Akun sekolah berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus akun sekolah.');
        }
    }
}

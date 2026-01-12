<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PublicSekolahController extends Controller
{
    public function showRegistrationForm()
    {
        return view('public.sekolah-register');
    }

    public function register(Request $request)
    {
        // Debug: Log bahwa request masuk
        \Log::info('Register request received', ['data' => $request->except('sk_pendaftar')]);
        
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|max:20|unique:users,npsn',
            'provinsi' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'email_belajar_sekolah' => 'required|email|unique:users,email_belajar_sekolah',
            'no_wa' => 'required|string|max:20',
            'nama_pendaftar' => 'required|string|max:255',
            'jabatan_pendaftar' => 'required|in:Wakasek Kurikulum,Wakasek Humas Hubin,Lainnya',
            'sk_pendaftar' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        \Log::info('Validation passed', ['validated' => $validated]);

        try {
            // Upload SK Pendaftar
            $skPath = null;
            if ($request->hasFile('sk_pendaftar')) {
                $file = $request->file('sk_pendaftar');
                $filename = time() . '_' . $validated['npsn'] . '.' . $file->getClientOriginalExtension();
                $skPath = $file->storeAs('sk_pendaftar', $filename, 'public');
            }

            // Create user with role sekolah
            User::create([
                'name' => $validated['nama_sekolah'],
                'email' => $validated['email_belajar_sekolah'], // Gunakan email_belajar_sekolah untuk email login
                'password' => Hash::make($validated['npsn']), // Default password = NPSN
                'role' => 'sekolah',
                'npsn' => $validated['npsn'],
                'nama_sekolah' => $validated['nama_sekolah'],
                'provinsi' => $validated['provinsi'],
                'kabupaten_kota' => $validated['kabupaten_kota'],
                'nama_kepala_sekolah' => $validated['nama_kepala_sekolah'],
                'email_belajar_sekolah' => $validated['email_belajar_sekolah'],
                'no_wa' => $validated['no_wa'],
                'nama_pendaftar' => $validated['nama_pendaftar'],
                'jabatan_pendaftar' => $validated['jabatan_pendaftar'],
                'sk_pendaftar_path' => $skPath,
                'approval_status' => 'pending',
                'status' => 'inactive', // Inactive until approved
            ]);

            return redirect()->route('sekolah.register')
                ->with('success', 'Pendaftaran berhasil! Silakan tunggu approval dari admin. Anda akan menerima email konfirmasi setelah akun disetujui.');

        } catch (\Exception $e) {
            \Log::error('Error registrasi sekolah: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

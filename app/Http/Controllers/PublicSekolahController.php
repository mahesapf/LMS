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
        // Debug: Log SEMUA input yang diterima
        \Log::info('========== REGISTRASI SEKOLAH - DEBUG START ==========');
        \Log::info('Method: ' . $request->method());
        \Log::info('URL: ' . $request->fullUrl());
        \Log::info('All Input Data:', $request->all());
        \Log::info('Has email_belajar: ' . ($request->has('email_belajar') ? 'YES' : 'NO'));
        \Log::info('Filled email_belajar: ' . ($request->filled('email_belajar') ? 'YES' : 'NO'));
        \Log::info('Email belajar value: "' . $request->input('email_belajar') . '"');
        \Log::info('Email belajar length: ' . strlen($request->input('email_belajar') ?? ''));
        \Log::info('Raw POST:', $_POST);
        \Log::info('Input names:', array_keys($request->all()));

        // Cek apakah email_belajar benar-benar kosong
        $emailBelajar = $request->input('email_belajar');
        if (empty($emailBelajar)) {
            \Log::error('PROBLEM: Email belajar is EMPTY!');
            \Log::error('Request all keys: ' . implode(', ', array_keys($request->all())));
        } else {
            \Log::info('Email belajar NOT empty: ' . $emailBelajar);
        }

        try {
            $validated = $request->validate([
                'nama_sekolah' => 'required|string|max:150',
                'npsn' => 'required|string|size:8|unique:users,npsn,NULL,id,deleted_at,NULL',
                'provinsi' => 'required|string|max:100',
                'kabupaten_kota' => 'required|string|max:100',
                'kecamatan' => 'required|string|max:100',
                'alamat_sekolah' => 'required|string',
                'nama_kepala_sekolah' => 'required|string|max:100',
                'email_belajar' => [
                    'required',
                    'email',
                    'unique:users,email_belajar,NULL,id,deleted_at,NULL'
                ],
                'no_wa' => 'required|string|max:15',
                'nama_pendaftar' => 'required|string|max:100',
                'jabatan_pendaftar' => 'required|string|max:50|in:Wakasek Kurikulum,Wakasek Humas Hubin,Lainnya',
                'sk_pendaftar' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ], [
                'nama_sekolah.required' => 'Nama sekolah harus diisi',
                'nama_sekolah.max' => 'Nama sekolah maksimal 150 karakter',
                'npsn.required' => 'NPSN harus diisi',
                'npsn.size' => 'NPSN harus 8 digit',
                'npsn.unique' => 'NPSN sudah terdaftar dalam sistem. Silakan gunakan NPSN lain atau hubungi administrator.',
                'provinsi.required' => 'Provinsi harus dipilih',
                'kabupaten_kota.required' => 'Kabupaten/Kota harus dipilih',
                'kecamatan.required' => 'Kecamatan harus diisi',
                'alamat_sekolah.required' => 'Alamat sekolah harus diisi',
                'nama_kepala_sekolah.required' => 'Nama kepala sekolah harus diisi',
                'nama_kepala_sekolah.max' => 'Nama kepala sekolah maksimal 100 karakter',
                'email_belajar.required' => 'Email harus diisi',
                'email_belajar.email' => 'Format email tidak valid',
                'email_belajar.unique' => 'Email sudah terdaftar. Silakan gunakan email lain atau hubungi administrator.',
                'no_wa.required' => 'Nomor WhatsApp harus diisi',
                'no_wa.max' => 'Nomor WhatsApp maksimal 15 karakter',
                'nama_pendaftar.required' => 'Nama pendaftar harus diisi',
                'nama_pendaftar.max' => 'Nama pendaftar maksimal 100 karakter',
                'jabatan_pendaftar.required' => 'Jabatan pendaftar harus dipilih',
                'jabatan_pendaftar.max' => 'Jabatan pendaftar maksimal 50 karakter',
                'jabatan_pendaftar.in' => 'Jabatan pendaftar tidak valid',
                'sk_pendaftar.required' => 'File SK pendaftar harus diupload',
                'sk_pendaftar.mimes' => 'File SK pendaftar harus berformat PDF, JPG, JPEG, atau PNG',
                'sk_pendaftar.max' => 'Ukuran file SK pendaftar maksimal 2MB',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'email_belajar_value' => $request->input('email_belajar'),
            ]);
            throw $e;
        }

        \Log::info('Validation passed', ['validated' => $validated]);

        try {
            // Cek apakah email sudah digunakan (termasuk yang soft deleted)
            // Jika soft deleted, restore dulu sebelum update
            $existingUser = User::withTrashed()
                ->where('email', $validated['email_belajar'])
                ->orWhere('email_belajar', $validated['email_belajar'])
                ->first();

            if ($existingUser && $existingUser->trashed()) {
                // Restore user yang soft deleted dan update datanya
                $existingUser->restore();

                // Update data dengan data baru
                if ($request->hasFile('sk_pendaftar')) {
                    $file = $request->file('sk_pendaftar');
                    $filename = time() . '_' . $validated['npsn'] . '.' . $file->getClientOriginalExtension();
                    $skPath = $file->storeAs('sk_pendaftar', $filename, 'public');
                    $existingUser->sk_pendaftar = $skPath;
                    $existingUser->sk_pendaftar_path = $skPath;
                }

                $existingUser->update([
                    'name' => $validated['nama_sekolah'],
                    'email' => $validated['email_belajar'],
                    'password' => Hash::make($validated['npsn']),
                    'role' => 'sekolah',
                    'npsn' => $validated['npsn'],
                    'nama_sekolah' => $validated['nama_sekolah'],
                    'email_belajar' => $validated['email_belajar'],
                    'provinsi' => $validated['provinsi'],
                    'province' => $validated['provinsi'],
                    'kabupaten' => $validated['kabupaten_kota'],
                    'kabupaten_kota' => $validated['kabupaten_kota'],
                    'city' => $validated['kabupaten_kota'],
                    'kecamatan' => $validated['kecamatan'],
                    'alamat_sekolah' => $validated['alamat_sekolah'],
                    'nama_kepala_sekolah' => $validated['nama_kepala_sekolah'],
                    'nama_pendaftar' => $validated['nama_pendaftar'],
                    'pendaftar' => $validated['nama_pendaftar'],
                    'jabatan_pendaftar' => $validated['jabatan_pendaftar'],
                    'no_wa' => $validated['no_wa'],
                    'no_hp' => $validated['no_wa'],
                    'status' => 'inactive',
                    'approval_status' => 'pending',
                ]);

                return redirect()->route('login')
                    ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan dari administrator.');
            }

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
                'email' => $validated['email_belajar'], // Email untuk login
                'password' => Hash::make($validated['npsn']), // Default password = NPSN
                'role' => 'sekolah',
                'npsn' => $validated['npsn'],
                'nama_sekolah' => $validated['nama_sekolah'],
                'email_belajar' => $validated['email_belajar'],
                'provinsi' => $validated['provinsi'],
                'province' => $validated['provinsi'],
                'kabupaten' => $validated['kabupaten_kota'],
                'kabupaten_kota' => $validated['kabupaten_kota'],
                'city' => $validated['kabupaten_kota'],
                'kecamatan' => $validated['kecamatan'],
                'alamat_sekolah' => $validated['alamat_sekolah'],
                'nama_kepala_sekolah' => $validated['nama_kepala_sekolah'],
                'nama_pendaftar' => $validated['nama_pendaftar'],
                'pendaftar' => $validated['nama_pendaftar'],
                'jabatan_pendaftar' => $validated['jabatan_pendaftar'],
                'no_wa' => $validated['no_wa'],
                'no_hp' => $validated['no_wa'],
                'sk_pendaftar' => $skPath,
                'sk_pendaftar_path' => $skPath,
                'status' => 'inactive', // Status inactive sampai diapprove
                'approval_status' => 'pending', // Menunggu approval dari superadmin
            ]);

            return redirect()->route('login')
                ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan dari administrator.');

        } catch (\Exception $e) {
            \Log::error('Error registrasi sekolah: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pendaftaran. Silakan coba lagi atau hubungi administrator jika masalah berlanjut. Detail error: ' . $e->getMessage());
        }
    }
}

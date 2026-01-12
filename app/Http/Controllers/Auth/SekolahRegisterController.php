<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SekolahRegisterController extends Controller
{
    /**
     * Show the sekolah registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register-sekolah');
    }

    /**
     * Handle sekolah registration request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:20', 'unique:users,npsn'],
            'provinsi' => ['required', 'string'],
            'kabupaten' => ['required', 'string', 'max:255'],
            'nama_kepala_sekolah' => ['required', 'string', 'max:255'],
            'email_belajar_id' => ['required', 'string', 'email', 'max:255', 'unique:users,email_belajar_id', 'regex:/belajar\.id$/i'],
            'no_wa' => ['required', 'string', 'max:20'],
            'pendaftar' => ['required', 'string', 'max:255'],
            'jabatan_pendaftar' => ['required', 'string', 'in:Wakasek Kurikulum,Wakasek Hubin/Humas'],
            'sk_pendaftar' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'email_belajar_id.regex' => 'Email harus menggunakan domain belajar.id (contoh: nama@smk.belajar.id)',
            'npsn.unique' => 'NPSN sudah terdaftar.',
            'email_belajar_id.unique' => 'Email belajar.id sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Upload SK Pendaftar
            $skPath = null;
            if ($request->hasFile('sk_pendaftar')) {
                $file = $request->file('sk_pendaftar');
                $filename = 'sk_' . time() . '_' . $file->getClientOriginalName();
                $skPath = $file->storeAs('public/sk_pendaftar', $filename);
            }

            // Create user with sekolah role
            $user = User::create([
                'name' => $request->nama_sekolah,
                'nama_sekolah' => $request->nama_sekolah,
                'npsn' => $request->npsn,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
                'email' => $request->email_belajar_id,
                'email_belajar_id' => $request->email_belajar_id,
                'no_wa' => $request->no_wa,
                'pendaftar' => $request->pendaftar,
                'jabatan_pendaftar' => $request->jabatan_pendaftar,
                'sk_pendaftar' => str_replace('public/', '', $skPath),
                'role' => 'sekolah',
                'password' => Hash::make($request->npsn), // Password default adalah NPSN
                'approval_status' => 'pending',
                'status' => 'inactive', // Inactive sampai di-approve
            ]);

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan dari admin. Anda akan menerima email konfirmasi setelah akun disetujui.');

        } catch (\Exception $e) {
            // Delete uploaded file if user creation fails
            if ($skPath && Storage::exists($skPath)) {
                Storage::delete($skPath);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.')
                ->withInput();
        }
    }
}

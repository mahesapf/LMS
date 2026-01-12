@extends('layouts.app')

@section('title', 'Registrasi Sekolah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-blue-50 py-12">
    <div class="mx-auto max-w-3xl px-4">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900">Registrasi Sekolah</h1>
            <p class="mt-2 text-slate-600">Daftarkan sekolah Anda untuk mengikuti kegiatan penjaminan mutu</p>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-emerald-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-emerald-800">Pendaftaran Berhasil!</h3>
                        <p class="mt-1 text-sm text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-red-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">Terjadi Kesalahan</h3>
                        <p class="mt-1 text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-red-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">Mohon perbaiki kesalahan berikut:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <form action="{{ route('sekolah.register.submit') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Data Sekolah -->
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Data Sekolah</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Nama Sekolah <span class="text-red-600">*</span></label>
                            <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('nama_sekolah') border-red-500 @enderror">
                            @error('nama_sekolah')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">NPSN <span class="text-red-600">*</span></label>
                            <input type="text" name="npsn" value="{{ old('npsn') }}" required
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('npsn') border-red-500 @enderror">
                            @error('npsn')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">NPSN akan digunakan sebagai username dan password default</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nama Kepala Sekolah <span class="text-red-600">*</span></label>
                            <input type="text" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah') }}" required
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('nama_kepala_sekolah') border-red-500 @enderror">
                            @error('nama_kepala_sekolah')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Provinsi <span class="text-red-600">*</span></label>
                            <select name="provinsi" id="provinsi" onchange="onProvinsiChange()" required
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('provinsi') border-red-500 @enderror">
                                <option value="">Pilih Provinsi</option>
                            </select>
                            @error('provinsi')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Kabupaten/Kota <span class="text-red-600">*</span></label>
                            <select name="kabupaten_kota" id="kabupaten_kota" required
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('kabupaten_kota') border-red-500 @enderror">
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                            @error('kabupaten_kota')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Email Belajar.id Sekolah <span class="text-red-600">*</span></label>
                            <input type="email" name="email_belajar_sekolah" value="{{ old('email_belajar_sekolah') }}" required
                                placeholder="sekolah@belajar.id"
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('email_belajar_sekolah') border-red-500 @enderror">
                            @error('email_belajar_sekolah')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nomor WhatsApp <span class="text-red-600">*</span></label>
                            <input type="text" name="no_wa" value="{{ old('no_wa') }}" required
                                placeholder="08xxxxxxxxxx"
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('no_wa') border-red-500 @enderror">
                            @error('no_wa')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Pendaftar -->
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Data Pendaftar</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nama Pendaftar <span class="text-red-600">*</span></label>
                            <input type="text" name="nama_pendaftar" value="{{ old('nama_pendaftar') }}" required
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('nama_pendaftar') border-red-500 @enderror">
                            @error('nama_pendaftar')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Jabatan Pendaftar <span class="text-red-600">*</span></label>
                            <select name="jabatan_pendaftar" required
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('jabatan_pendaftar') border-red-500 @enderror">
                                <option value="">Pilih Jabatan</option>
                                <option value="Wakasek Kurikulum" {{ old('jabatan_pendaftar') == 'Wakasek Kurikulum' ? 'selected' : '' }}>Wakasek Kurikulum</option>
                                <option value="Wakasek Humas Hubin" {{ old('jabatan_pendaftar') == 'Wakasek Humas Hubin' ? 'selected' : '' }}>Wakasek Humas Hubin</option>
                                <option value="Lainnya" {{ old('jabatan_pendaftar') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jabatan_pendaftar')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Upload SK Pendaftar <span class="text-red-600">*</span></label>
                            <input type="file" name="sk_pendaftar" accept=".pdf,.jpg,.jpeg,.png" required
                                class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 @error('sk_pendaftar') border-red-500 @enderror">
                            @error('sk_pendaftar')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-between border-t border-slate-200 pt-6">
                    <a href="{{ route('home') }}" class="text-sm text-slate-600 hover:text-slate-900">
                        ← Kembali ke Beranda
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-sky-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Daftar Sekolah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/indonesia-location.js') }}"></script>
<script>
// Populate provinsi dropdown
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi');
    const kabKotaSelect = document.getElementById('kabupaten_kota');
    
    // Populate provinsi
    for (const provinsi in locationData) {
        const option = document.createElement('option');
        option.value = provinsi;
        option.textContent = provinsi;
        if ("{{ old('provinsi') }}" === provinsi) {
            option.selected = true;
        }
        provinsiSelect.appendChild(option);
    }
    
    // If old provinsi exists, populate kab/kota
    if ("{{ old('provinsi') }}") {
        onProvinsiChange();
    }
});

function onProvinsiChange() {
    const provinsiSelect = document.getElementById('provinsi');
    const kabKotaSelect = document.getElementById('kabupaten_kota');
    const provinsi = provinsiSelect.value;
    
    // Clear kabupaten/kota
    kabKotaSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
    
    if (provinsi && locationData[provinsi]) {
        const kabKotaList = Object.keys(locationData[provinsi]);
        kabKotaList.forEach(kabKota => {
            const option = document.createElement('option');
            option.value = kabKota;
            option.textContent = kabKota;
            if ("{{ old('kabupaten_kota') }}" === kabKota) {
                option.selected = true;
            }
            kabKotaSelect.appendChild(option);
        });
    }
}
</script>
@endsection

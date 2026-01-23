@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('title', 'Registrasi Sekolah')

@section('content')
<div class="auth-wrapper">
    <div class="auth-left"></div>
    <div class="auth-right">
        <div class="auth-card">
            <div class="auth-card-header position-relative">
                <a href="{{ url('/') }}" class="position-absolute top-0 end-0 m-3" style="text-decoration: none;" title="Kembali">
                    <button class="btn btn-outline-secondary btn-sm" type="button" style="color: #374151 !important;">
                        <i class="bi bi-arrow-left" style="color: #374151 !important;"></i>
                    </button>
                </a>
                <img src="{{ asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="auth-logo">
                <h4>Registrasi Sekolah</h4>
                <p>Sistem Informasi Penjaminan Mutu</p>
            </div>

            <div class="auth-card-body">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-emerald-500 shadow-md">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-base font-bold text-emerald-900 mb-2">Pendaftaran Berhasil!</h3>
                                <p class="text-sm text-emerald-800">{{ session('success') }}</p>
                            </div>
                            <button type="button" class="ml-3 flex-shrink-0 text-emerald-400 hover:text-emerald-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-semibold text-red-800 mb-1">Terjadi Kesalahan</h3>
                                <div class="text-sm text-red-700">
                                    {{ session('error') }}
                                </div>
                            </div>
                            <button type="button" class="ml-3 flex-shrink-0 text-red-400 hover:text-red-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-semibold text-red-800 mb-2">Mohon perbaiki kesalahan berikut:</h3>
                                <ul class="space-y-1 text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                        <li class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>{{ $error }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="ml-3 flex-shrink-0 text-red-400 hover:text-red-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <form action="{{ route('sekolah.register.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="auth-form-group">
                        <label for="nama_sekolah" class="auth-form-label">Nama Sekolah <span class="text-danger">*</span></label>
                        <input id="nama_sekolah" type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required autofocus maxlength="150"
                            class="auth-form-control @error('nama_sekolah') is-invalid @enderror" placeholder="Masukkan nama sekolah">
                        @error('nama_sekolah')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="auth-form-group">
                                <label for="npsn" class="auth-form-label">NPSN <span class="text-danger">*</span></label>
                                <input id="npsn" type="text" name="npsn" value="{{ old('npsn') }}" required maxlength="8" pattern="[0-9]{8}"
                                    class="auth-form-control @error('npsn') is-invalid @enderror" placeholder="8 digit NPSN">
                                @error('npsn')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <small class="text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="auth-form-group">
                                <label for="nama_kepala_sekolah" class="auth-form-label">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                                <input id="nama_kepala_sekolah" type="text" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah') }}" required maxlength="100"
                                    class="auth-form-control @error('nama_kepala_sekolah') is-invalid @enderror" placeholder="Nama kepala sekolah">
                                @error('nama_kepala_sekolah')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="auth-form-group">
                                <label for="email_belajar" class="auth-form-label">Email Sekolah <span class="text-danger">*</span></label>
                                <input id="email_belajar"
                                       type="email"
                                       name="email_belajar"
                                       value="{{ old('email_belajar') }}"
                                       required
                                       autocomplete="off"
                                       class="auth-form-control @error('email_belajar') is-invalid @enderror"
                                       placeholder="email@sekolah.sch.id">
                                @error('email_belajar')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <small class="text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="auth-form-group">
                                <label for="no_wa" class="auth-form-label">No. WhatsApp <span class="text-danger">*</span></label>
                                <input id="no_wa" type="text" name="no_wa" value="{{ old('no_wa') }}" required maxlength="15"
                                    class="auth-form-control @error('no_wa') is-invalid @enderror" placeholder="08xxx">
                                @error('no_wa')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="auth-form-group">
                                <label for="provinsi" class="auth-form-label">Provinsi <span class="text-danger">*</span></label>
                                <select id="provinsi" name="provinsi" onchange="onProvinsiChange()" required
                                    class="auth-form-control @error('provinsi') is-invalid @enderror">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                @error('provinsi')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="auth-form-group">
                                <label for="kabupaten_kota" class="auth-form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <select id="kabupaten_kota" name="kabupaten_kota" onchange="onKabupatenChange()" required
                                    class="auth-form-control @error('kabupaten_kota') is-invalid @enderror">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                                @error('kabupaten_kota')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="auth-form-group">
                                <label for="kecamatan" class="auth-form-label">Kecamatan <span class="text-danger">*</span></label>
                                <select id="kecamatan" name="kecamatan" required
                                    class="auth-form-control @error('kecamatan') is-invalid @enderror">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('kecamatan')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="auth-form-group">
                                <label for="alamat_sekolah" class="auth-form-label">Alamat Sekolah <span class="text-danger">*</span></label>
                                <input id="alamat_sekolah" type="text" name="alamat_sekolah" value="{{ old('alamat_sekolah') }}" required
                                    class="auth-form-control @error('alamat_sekolah') is-invalid @enderror" placeholder="Masukkan alamat lengkap sekolah">
                                @error('alamat_sekolah')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="auth-form-group">
                                <label for="nama_pendaftar" class="auth-form-label">Nama Pendaftar <span class="text-danger">*</span></label>
                                <input id="nama_pendaftar" type="text" name="nama_pendaftar" value="{{ old('nama_pendaftar') }}" required maxlength="100"
                                    class="auth-form-control @error('nama_pendaftar') is-invalid @enderror" placeholder="Nama pendaftar">
                                @error('nama_pendaftar')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="auth-form-group">
                                <label for="jabatan_pendaftar" class="auth-form-label">Jabatan <span class="text-danger">*</span></label>
                                <select id="jabatan_pendaftar" name="jabatan_pendaftar" required
                                    class="auth-form-control @error('jabatan_pendaftar') is-invalid @enderror">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Wakasek Kurikulum" {{ old('jabatan_pendaftar') == 'Wakasek Kurikulum' ? 'selected' : '' }}>Wakasek Kurikulum</option>
                                    <option value="Wakasek Humas Hubin" {{ old('jabatan_pendaftar') == 'Wakasek Humas Hubin' ? 'selected' : '' }}>Wakasek Humas Hubin</option>
                                    <option value="Lainnya" {{ old('jabatan_pendaftar') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jabatan_pendaftar')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="auth-form-group">
                        <label for="sk_pendaftar" class="auth-form-label">Upload SK Pendaftar <span class="text-danger">*</span></label>
                        <input id="sk_pendaftar" type="file" name="sk_pendaftar" accept=".pdf,.jpg,.jpeg,.png" required
                            class="auth-form-control @error('sk_pendaftar') is-invalid @enderror">
                        @error('sk_pendaftar')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB</small>
                    </div>

                    <button type="submit" class="auth-btn-primary">
                        Daftar Sekolah
                    </button>

                    <div class="auth-footer-text text-center mt-3">
                        <small class="text-muted">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/indonesia-location.js') }}"></script>
<script>
// Populate provinsi dropdown
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi');
    const kabKotaSelect = document.getElementById('kabupaten_kota');
    const kecamatanSelect = document.getElementById('kecamatan');

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

    // If old kabupaten_kota exists, populate kecamatan
    if ("{{ old('kabupaten_kota') }}") {
        onKabupatenChange();
    }
});

function onProvinsiChange() {
    const provinsiSelect = document.getElementById('provinsi');
    const kabKotaSelect = document.getElementById('kabupaten_kota');
    const kecamatanSelect = document.getElementById('kecamatan');
    const provinsi = provinsiSelect.value;

    // Clear kabupaten/kota and kecamatan
    kabKotaSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
    kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

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

function onKabupatenChange() {
    const provinsiSelect = document.getElementById('provinsi');
    const kabKotaSelect = document.getElementById('kabupaten_kota');
    const kecamatanSelect = document.getElementById('kecamatan');
    const provinsi = provinsiSelect.value;
    const kabKota = kabKotaSelect.value;

    // Clear kecamatan
    kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

    if (provinsi && kabKota && locationData[provinsi] && locationData[provinsi][kabKota]) {
        const kecamatanList = locationData[provinsi][kabKota];
        kecamatanList.forEach(kecamatan => {
            const option = document.createElement('option');
            option.value = kecamatan;
            option.textContent = kecamatan;
            if ("{{ old('kecamatan') }}" === kecamatan) {
                option.selected = true;
            }
            kecamatanSelect.appendChild(option);
        });
    }
}
</script>
@endsection

@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('content')
<div class="auth-wrapper">
    <div class="auth-left"></div>
    <div class="auth-right">
        <div class="auth-card">
            <div class="auth-card-header position-relative">
                <a href="{{ url('/') }}" class="position-absolute top-0 end-0 m-3" style="text-decoration: none;" title="Kembali">
                    <button class="btn btn-outline-secondary btn-sm" type="button">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </a>
                <img src="{{ asset('images/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="auth-logo">
                <h4>Registrasi Sekolah</h4>
                <p>Sistem Informasi Penjaminan Mutu</p>
            </div>

            <div class="auth-card-body">
                <form method="POST" action="{{ route('sekolah.register.submit') }}" enctype="multipart/form-data">
                    @csrf

            <div class="auth-form-group">
                <label for="nama_sekolah" class="auth-form-label">Nama Sekolah <span class="text-danger">*</span></label>
                <input id="nama_sekolah" type="text" class="auth-form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required autofocus placeholder="Masukkan nama sekolah">
                @error('nama_sekolah')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="npsn" class="auth-form-label">NPSN <span class="text-danger">*</span></label>
                <input id="npsn" type="text" class="auth-form-control @error('npsn') is-invalid @enderror" name="npsn" value="{{ old('npsn') }}" required placeholder="Nomor Pokok Sekolah Nasional">
                @error('npsn')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="provinsi" class="auth-form-label">Provinsi <span class="text-danger">*</span></label>
                <select id="provinsi" class="auth-form-control @error('provinsi') is-invalid @enderror" name="provinsi" required>
                    <option value="">Pilih Provinsi</option>
                    <option value="Aceh" {{ old('provinsi') == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                    <option value="Sumatera Utara" {{ old('provinsi') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                    <option value="Sumatera Barat" {{ old('provinsi') == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                    <option value="Riau" {{ old('provinsi') == 'Riau' ? 'selected' : '' }}>Riau</option>
                    <option value="Kepulauan Riau" {{ old('provinsi') == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                    <option value="Jambi" {{ old('provinsi') == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                    <option value="Sumatera Selatan" {{ old('provinsi') == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                    <option value="Kepulauan Bangka Belitung" {{ old('provinsi') == 'Kepulauan Bangka Belitung' ? 'selected' : '' }}>Kepulauan Bangka Belitung</option>
                    <option value="Bengkulu" {{ old('provinsi') == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                    <option value="Lampung" {{ old('provinsi') == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                    <option value="DKI Jakarta" {{ old('provinsi') == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                    <option value="Jawa Barat" {{ old('provinsi') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                    <option value="Banten" {{ old('provinsi') == 'Banten' ? 'selected' : '' }}>Banten</option>
                    <option value="Jawa Tengah" {{ old('provinsi') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                    <option value="DI Yogyakarta" {{ old('provinsi') == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                    <option value="Jawa Timur" {{ old('provinsi') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                    <option value="Bali" {{ old('provinsi') == 'Bali' ? 'selected' : '' }}>Bali</option>
                    <option value="Nusa Tenggara Barat" {{ old('provinsi') == 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                    <option value="Nusa Tenggara Timur" {{ old('provinsi') == 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                    <option value="Kalimantan Barat" {{ old('provinsi') == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                    <option value="Kalimantan Tengah" {{ old('provinsi') == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                    <option value="Kalimantan Selatan" {{ old('provinsi') == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                    <option value="Kalimantan Timur" {{ old('provinsi') == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                    <option value="Kalimantan Utara" {{ old('provinsi') == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                    <option value="Sulawesi Utara" {{ old('provinsi') == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                    <option value="Gorontalo" {{ old('provinsi') == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                    <option value="Sulawesi Tengah" {{ old('provinsi') == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                    <option value="Sulawesi Barat" {{ old('provinsi') == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                    <option value="Sulawesi Selatan" {{ old('provinsi') == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                    <option value="Sulawesi Tenggara" {{ old('provinsi') == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                    <option value="Maluku" {{ old('provinsi') == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                    <option value="Maluku Utara" {{ old('provinsi') == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                    <option value="Papua" {{ old('provinsi') == 'Papua' ? 'selected' : '' }}>Papua</option>
                    <option value="Papua Barat" {{ old('provinsi') == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                    <option value="Papua Tengah" {{ old('provinsi') == 'Papua Tengah' ? 'selected' : '' }}>Papua Tengah</option>
                    <option value="Papua Pegunungan" {{ old('provinsi') == 'Papua Pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
                    <option value="Papua Selatan" {{ old('provinsi') == 'Papua Selatan' ? 'selected' : '' }}>Papua Selatan</option>
                    <option value="Papua Barat Daya" {{ old('provinsi') == 'Papua Barat Daya' ? 'selected' : '' }}>Papua Barat Daya</option>
                </select>
                @error('provinsi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="kabupaten_kota" class="auth-form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                <select id="kabupaten_kota" class="auth-form-control @error('kabupaten_kota') is-invalid @enderror" name="kabupaten_kota" required disabled>
                    <option value="">Pilih Provinsi Terlebih Dahulu</option>
                </select>
                @error('kabupaten_kota')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="nama_kepala_sekolah" class="auth-form-label">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                <input id="nama_kepala_sekolah" type="text" class="auth-form-control @error('nama_kepala_sekolah') is-invalid @enderror" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah') }}" required placeholder="Masukkan nama kepala sekolah">
                @error('nama_kepala_sekolah')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="email_belajar" class="auth-form-label">Email Sekolah <span class="text-danger">*</span></label>
                <input id="email_belajar"
                       type="email"
                       class="auth-form-control @error('email_belajar') is-invalid @enderror"
                       name="email_belajar"
                       value="{{ old('email_belajar') }}"
                       required
                       autocomplete="off"
                       placeholder="email@sekolah.sch.id">
                @error('email_belajar')
                    <span class="invalid-feedback" role="alert" data-server-error>
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <small class="text-muted">Email ini akan digunakan untuk login. Bisa menggunakan email apa saja.</small>
            </div>

            <div class="auth-form-group">
                <label for="no_wa" class="auth-form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                <input id="no_wa" type="text" class="auth-form-control @error('no_wa') is-invalid @enderror" name="no_wa" value="{{ old('no_wa') }}" required placeholder="08xxxxxxxxxx">
                @error('no_wa')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="nama_pendaftar" class="auth-form-label">Nama Pendaftar <span class="text-danger">*</span></label>
                <input id="nama_pendaftar" type="text" class="auth-form-control @error('nama_pendaftar') is-invalid @enderror" name="nama_pendaftar" value="{{ old('nama_pendaftar') }}" required placeholder="Masukkan nama pendaftar">
                @error('nama_pendaftar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="jabatan_pendaftar" class="auth-form-label">Jabatan Pendaftar <span class="text-danger">*</span></label>
                <select id="jabatan_pendaftar" class="auth-form-control @error('jabatan_pendaftar') is-invalid @enderror" name="jabatan_pendaftar" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Wakasek Kurikulum" {{ old('jabatan_pendaftar') == 'Wakasek Kurikulum' ? 'selected' : '' }}>Wakasek Kurikulum</option>
                    <option value="Wakasek Hubin/Humas" {{ old('jabatan_pendaftar') == 'Wakasek Hubin/Humas' ? 'selected' : '' }}>Wakasek Hubin/Humas</option>
                </select>
                @error('jabatan_pendaftar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="sk_pendaftar" class="auth-form-label">Upload SK Pendaftar <span class="text-danger">*</span></label>
                <input id="sk_pendaftar" type="file" class="auth-form-control @error('sk_pendaftar') is-invalid @enderror" name="sk_pendaftar" required accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Format: PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                @error('sk_pendaftar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi');
    const kabupatenSelect = document.getElementById('kabupaten_kota');
    const emailBelajarInput = document.getElementById('email_belajar');
    const form = document.querySelector('form');

    // Validasi email standar
    if (emailBelajarInput) {
        // Real-time indicator
        emailBelajarInput.addEventListener('input', function() {
            const email = this.value.trim();
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email) {
                if (regex.test(email)) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });

        emailBelajarInput.addEventListener('blur', function() {
            const email = this.value.trim();
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !regex.test(email)) {
                this.classList.add('is-invalid');
                let errorDiv = this.nextElementSibling;
                if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv = document.createElement('span');
                    errorDiv.classList.add('invalid-feedback');
                    errorDiv.setAttribute('role', 'alert');
                    errorDiv.innerHTML = '<strong>Format email tidak valid</strong>';
                    this.parentNode.insertBefore(errorDiv, this.nextSibling);
                } else {
                    errorDiv.innerHTML = '<strong>Format email tidak valid</strong>';
                }
            } else {
                this.classList.remove('is-invalid');
                const errorDiv = this.nextElementSibling;
                if (errorDiv && errorDiv.classList.contains('invalid-feedback') && !errorDiv.hasAttribute('data-server-error')) {
                    errorDiv.remove();
                }
            }
        });

        // Trim whitespace on submit
        form.addEventListener('submit', function(e) {
            const emailValue = emailBelajarInput.value.trim();
            emailBelajarInput.value = emailValue;

            console.log('Form submit - Email value:', emailValue);
            console.log('Form submit - Email length:', emailValue.length);

            // Final validation check
            if (!emailValue) {
                e.preventDefault();
                alert('Email harus diisi!\n\nField masih kosong. Silakan isi dengan email Anda.');
                emailBelajarInput.focus();
                return false;
            }

            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(emailValue)) {
                e.preventDefault();
                alert('Format email tidak valid!\n\nSilakan masukkan email yang benar.');
                emailBelajarInput.focus();
                return false;
            }

            console.log('Form validation passed, submitting...');
        });
    }

    provinsiSelect.addEventListener('change', function() {
        const selectedProvinsi = this.value;

        // Clear existing options
        kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';

        // Use locationData dari indonesia-location.js
        if (selectedProvinsi && locationData && locationData[selectedProvinsi]) {
            // Enable kabupaten dropdown
            kabupatenSelect.disabled = false;

            // Add kabupaten options
            const kabupatenList = locationData[selectedProvinsi];

            // Handle jika locationData adalah object dengan city/kota keys
            if (typeof kabupatenList === 'object' && !Array.isArray(kabupatenList)) {
                Object.keys(kabupatenList).forEach(function(kabupaten) {
                    const option = document.createElement('option');
                    option.value = kabupaten;
                    option.textContent = kabupaten;

                    if (kabupaten === '{{ old("kabupaten_kota") }}') {
                        option.selected = true;
                    }

                    kabupatenSelect.appendChild(option);
                });
            }
        } else {
            // Disable kabupaten dropdown
            kabupatenSelect.disabled = true;
        }
    });

    // Trigger change event if old provinsi exists
    @if(old('provinsi'))
        provinsiSelect.value = '{{ old("provinsi") }}';
        provinsiSelect.dispatchEvent(new Event('change'));
    @endif
});
</script>
@endsection

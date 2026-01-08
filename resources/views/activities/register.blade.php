@extends('layouts.app')

@section('title', 'Pendaftaran - ' . $activity->name)

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('activities.show', $activity) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Detail Kegiatan
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Pendaftaran Kegiatan</h4>
                    <p class="mb-0 mt-2"><strong>{{ $activity->name }}</strong></p>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('activities.register', $activity) }}">
                        @csrf

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Informasi Sekolah</h5>
                        </div>

                        <div class="mb-3">
                            <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_sekolah') is-invalid @enderror" 
                                   id="nama_sekolah" 
                                   name="nama_sekolah" 
                                   value="{{ old('nama_sekolah') }}" 
                                   required
                                   placeholder="Contoh: SMA Negeri 1 Jakarta">
                            @error('nama_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat_sekolah" class="form-label">Alamat Sekolah <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat_sekolah') is-invalid @enderror" 
                                      id="alamat_sekolah" 
                                      name="alamat_sekolah" 
                                      rows="3" 
                                      required
                                      placeholder="Masukkan alamat lengkap sekolah">{{ old('alamat_sekolah') }}</textarea>
                            @error('alamat_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('provinsi') is-invalid @enderror" 
                                       id="provinsi" 
                                       name="provinsi" 
                                       value="{{ old('provinsi') }}" 
                                       required
                                       placeholder="Contoh: DKI Jakarta">
                                @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kab_kota" class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('kab_kota') is-invalid @enderror" 
                                       id="kab_kota" 
                                       name="kab_kota" 
                                       value="{{ old('kab_kota') }}" 
                                       required
                                       placeholder="Contoh: Jakarta Selatan">
                                @error('kab_kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="kcd" class="form-label">KCD (Kantor Cabang Dinas) <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('kcd') is-invalid @enderror" 
                                   id="kcd" 
                                   name="kcd" 
                                   value="{{ old('kcd') }}" 
                                   required
                                   placeholder="Contoh: KCD Jakarta Selatan">
                            @error('kcd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 mt-4">
                            <h5 class="border-bottom pb-2">Informasi Kontak</h5>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kepala_sekolah" class="form-label">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_kepala_sekolah') is-invalid @enderror" 
                                   id="nama_kepala_sekolah" 
                                   name="nama_kepala_sekolah" 
                                   value="{{ old('nama_kepala_sekolah') }}" 
                                   required
                                   placeholder="Masukkan nama lengkap kepala sekolah">
                            @error('nama_kepala_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor_telp" class="form-label">Nomor yang Dapat Dihubungi <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control @error('nomor_telp') is-invalid @enderror" 
                                   id="nomor_telp" 
                                   name="nomor_telp" 
                                   value="{{ old('nomor_telp') }}" 
                                   required
                                   placeholder="Contoh: 081234567890">
                            @error('nomor_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email (Opsional)</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="email@sekolah.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Email untuk konfirmasi (jika ada)</small>
                        </div>

                        <div class="mb-4 mt-4">
                            <h5 class="border-bottom pb-2">Jumlah Peserta</h5>
                        </div>

                        @if($activity->registration_fee > 0)
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Biaya Kegiatan:</strong> Rp {{ number_format($activity->registration_fee, 0, ',', '.') }} per peserta
                            <br>
                            <small>Total biaya akan dihitung berdasarkan jumlah peserta yang didaftarkan.</small>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="jumlah_peserta" class="form-label">Jumlah Peserta <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('jumlah_peserta') is-invalid @enderror" 
                                       id="jumlah_peserta" 
                                       name="jumlah_peserta" 
                                       value="{{ old('jumlah_peserta', 0) }}" 
                                       min="0" 
                                       required
                                       placeholder="0"
                                       onchange="calculateTotal()">
                                @error('jumlah_peserta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Total semua peserta</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_kepala_sekolah" class="form-label">Kepala Sekolah <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('jumlah_kepala_sekolah') is-invalid @enderror" 
                                       id="jumlah_kepala_sekolah" 
                                       name="jumlah_kepala_sekolah" 
                                       value="{{ old('jumlah_kepala_sekolah', 0) }}" 
                                       min="0" 
                                       required
                                       placeholder="0"
                                       onchange="calculateTotal()">
                                @error('jumlah_kepala_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Berapa orang</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jumlah_guru" class="form-label">Guru <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('jumlah_guru') is-invalid @enderror" 
                                       id="jumlah_guru" 
                                       name="jumlah_guru" 
                                       value="{{ old('jumlah_guru', 0) }}" 
                                       min="0" 
                                       required
                                       placeholder="0"
                                       onchange="calculateTotal()">
                                @error('jumlah_guru')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Berapa orang</small>
                            </div>
                        </div>

                        @if($activity->registration_fee > 0)
                        <div class="card border-primary mb-4">
                            <div class="card-body">
                                <h6 class="mb-2">Estimasi Biaya Total:</h6>
                                <h3 class="text-primary mb-0" id="total-biaya">Rp 0</h3>
                                <small class="text-muted">Total biaya = Jumlah peserta × Rp {{ number_format($activity->registration_fee, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        @endif

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Pendaftaran Per Sekolah:</strong> Sistem ini adalah pendaftaran per sekolah. Anda dapat mendaftarkan beberapa peserta (kepala sekolah dan guru) dari sekolah Anda dalam satu pendaftaran. Pembayaran akan dihitung berdasarkan total peserta yang didaftarkan.
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Daftar Sekarang
                            </button>
                            <a href="{{ route('activities.show', $activity) }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function calculateTotal() {
    const biayaPerPeserta = {{ $activity->registration_fee }};
    const jumlahPeserta = parseInt(document.getElementById('jumlah_peserta').value) || 0;
    const jumlahKepalaSekolah = parseInt(document.getElementById('jumlah_kepala_sekolah').value) || 0;
    const jumlahGuru = parseInt(document.getElementById('jumlah_guru').value) || 0;
    
    // If jumlah_peserta is filled, use it; otherwise use sum of kepala sekolah + guru
    const totalPeserta = jumlahPeserta > 0 ? jumlahPeserta : (jumlahKepalaSekolah + jumlahGuru);
    const totalBiaya = totalPeserta * biayaPerPeserta;
    
    document.getElementById('total-biaya').textContent = 'Rp ' + totalBiaya.toLocaleString('id-ID');
}

// Calculate on page load if values exist
document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endsection

@extends('layouts.app')

@section('title', $activity->name)

@push('styles')
<style>
/* Ensure modal can be displayed */
body:not(.auth-page) {
    overflow: visible !important;
}
.modal-backdrop {
    z-index: 1050;
}
.modal {
    z-index: 1055;
}
</style>
@endpush

@section('content')
<div class="container py-4" x-data="{ showRegistrationModal: {{ (old('nama_sekolah') || old('email')) ? 'true' : 'false' }} }">
    <div class="mb-4">
        <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kegiatan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="card-title mb-3">{{ $activity->name }}</h1>
                    
                    @if($activity->program)
                        <p class="text-muted">
                            <i class="bi bi-folder"></i> Program: <strong>{{ $activity->program->name }}</strong>
                        </p>
                    @endif

                    @if($activity->description)
                        <div class="mb-4">
                            <h5>Deskripsi</h5>
                            <p>{{ $activity->description }}</p>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informasi Kegiatan</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Tanggal Mulai</th>
                                    <td>{{ $activity->start_date->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>{{ $activity->end_date->format('d F Y') }}</td>
                                </tr>
                                @if($activity->batch)
                                <tr>
                                    <th>Batch</th>
                                    <td>{{ $activity->batch }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($activity->status == 'planned')
                                            <span class="badge bg-info">Direncanakan</span>
                                        @elseif($activity->status == 'ongoing')
                                            <span class="badge bg-success">Berlangsung</span>
                                        @elseif($activity->status == 'completed')
                                            <span class="badge bg-secondary">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Informasi Pembiayaan</h5>
                            <table class="table table-sm">
                                @if($activity->financing_type)
                                <tr>
                                    <th width="40%">Jenis Pembiayaan</th>
                                    <td>{{ $activity->financing_type }}</td>
                                </tr>
                                @endif
                                @if($activity->apbn_type)
                                <tr>
                                    <th>Tipe APBN</th>
                                    <td>{{ $activity->apbn_type }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Biaya Pendaftaran</th>
                                    <td>
                                        @if($activity->registration_fee > 0)
                                            <strong class="text-primary">Rp {{ number_format($activity->registration_fee, 0, ',', '.') }}</strong>
                                            <br>
                                            <small class="text-muted">per peserta</small>
                                        @else
                                            <span class="text-success">Gratis</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pendaftaran Per Sekolah</h5>
                </div>
                <div class="card-body">
                    @if($existingRegistration)
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle"></i> Sekolah Anda sudah terdaftar pada kegiatan ini
                        </div>
                        
                        <h6>Status Pendaftaran:</h6>
                        @if($existingRegistration->status == 'payment_pending')
                            <span class="badge bg-warning mb-3">Menunggu Pembayaran</span>
                            <p>Silakan upload bukti pembayaran untuk melanjutkan.</p>
                            <a href="{{ route('payment.create', $existingRegistration) }}" class="btn btn-primary w-100">
                                Upload Pembayaran
                            </a>
                        @elseif($existingRegistration->status == 'payment_uploaded')
                            <span class="badge bg-info mb-3">Menunggu Validasi</span>
                            <p>Bukti pembayaran Anda sedang divalidasi oleh admin.</p>
                        @elseif($existingRegistration->status == 'validated')
                            <span class="badge bg-success mb-3">Tervalidasi</span>
                            <p>Pendaftaran Anda telah divalidasi. Anda adalah peserta kegiatan ini.</p>
                        @elseif($existingRegistration->status == 'rejected')
                            <span class="badge bg-danger mb-3">Ditolak</span>
                            <p>Pembayaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        @endif
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Pendaftaran Per Sekolah</strong><br>
                            <small>Satu sekolah dapat mendaftarkan beberapa peserta dalam satu pendaftaran. Biaya dihitung berdasarkan total peserta.</small>
                        </div>
                        
                        <button type="button" @click="showRegistrationModal = true" class="btn btn-primary w-100">
                            <i class="bi bi-pencil-square"></i> Daftarkan Sekolah
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Pendaftaran -->
    <div x-show="showRegistrationModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div x-show="showRegistrationModal" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" 
             @click="showRegistrationModal = false"></div>

        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div x-show="showRegistrationModal" 
             @click.stop
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:align-middle">
            
            <form method="POST" action="{{ route('activities.register', $activity) }}" id="registrationForm">
                @csrf
                <div class="bg-white px-6 pt-5 pb-4">
                    <div class="flex items-start justify-between pb-3 border-b border-slate-200">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900" id="modal-title">Form Pendaftaran Kegiatan</h3>
                            <p class="text-sm text-slate-600 mt-1">{{ $activity->name }}</p>
                        </div>
                        <button type="button" @click.stop="showRegistrationModal = false" class="rounded-md text-slate-400 hover:text-slate-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-5">
                        <div class="mb-5 rounded-lg border border-blue-200 bg-blue-50 p-4">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <strong>Petunjuk Pengisian:</strong>
                                    <p class="mt-1">Silakan isi data sekolah dan jumlah peserta yang akan mengikuti kegiatan ini. Pastikan semua data terisi dengan benar.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Sekolah -->
                        <h6 class="text-sm font-semibold text-slate-900 mb-3 pb-2 border-b border-slate-200">📋 Informasi Sekolah</h6>
                        <div class="grid gap-4 sm:grid-cols-2 mb-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700">Nama Sekolah <span class="text-red-600">*</span></label>
                                <input type="text" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('nama_sekolah') border-red-500 @enderror" 
                                       name="nama_sekolah" 
                                       value="{{ old('nama_sekolah') }}" 
                                       required
                                       placeholder="Contoh: SMA Negeri 1 Jakarta">
                                @error('nama_sekolah')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700">Alamat Sekolah <span class="text-red-600">*</span></label>
                                <textarea class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('alamat_sekolah') border-red-500 @enderror" 
                                          name="alamat_sekolah" 
                                          rows="2" 
                                          required
                                          placeholder="Masukkan alamat lengkap sekolah">{{ old('alamat_sekolah') }}</textarea>
                                @error('alamat_sekolah')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Provinsi <span class="text-red-600">*</span></label>
                                <input type="text" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('provinsi') border-red-500 @enderror" 
                                       name="provinsi" 
                                       value="{{ old('provinsi') }}" 
                                       required
                                       placeholder="Contoh: DKI Jakarta">
                                @error('provinsi')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Kabupaten/Kota <span class="text-red-600">*</span></label>
                                <input type="text" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('kab_kota') border-red-500 @enderror" 
                                       name="kab_kota" 
                                       value="{{ old('kab_kota') }}" 
                                       required
                                       placeholder="Contoh: Jakarta Selatan">
                                @error('kab_kota')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700">KCD (Kantor Cabang Dinas) <span class="text-red-600">*</span></label>
                                <input type="text" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('kcd') border-red-500 @enderror" 
                                       name="kcd" 
                                       value="{{ old('kcd') }}" 
                                       required
                                       placeholder="Contoh: KCD Jakarta Selatan">
                                @error('kcd')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Kontak -->
                        <h6 class="text-sm font-semibold text-slate-900 mb-3 pb-2 border-b border-slate-200 mt-6">📞 Informasi Kontak</h6>
                        <div class="grid gap-4 sm:grid-cols-2 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Kepala Sekolah <span class="text-red-600">*</span></label>
                                <input type="text" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('nama_kepala_sekolah') border-red-500 @enderror" 
                                       name="nama_kepala_sekolah" 
                                       value="{{ old('nama_kepala_sekolah') }}" 
                                       required
                                       placeholder="Masukkan nama lengkap kepala sekolah">
                                @error('nama_kepala_sekolah')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">NIK Kepala Sekolah <span class="text-red-600">*</span></label>
                                <input type="text" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('nik_kepala_sekolah') border-red-500 @enderror" 
                                       name="nik_kepala_sekolah" 
                                       value="{{ old('nik_kepala_sekolah') }}" 
                                       required
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       placeholder="Masukkan NIK 16 digit">
                                @error('nik_kepala_sekolah')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">Nomor Induk Kependudukan 16 digit</p>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700">Email (Opsional)</label>
                                <input type="email" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('email') border-red-500 @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="email@sekolah.com">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">Email untuk konfirmasi (jika ada)</p>
                            </div>
                        </div>

                        <!-- Jumlah Peserta -->
                        <h6 class="text-sm font-semibold text-slate-900 mb-3 pb-2 border-b border-slate-200 mt-6">👥 Jumlah Peserta</h6>

                        @if($activity->registration_fee > 0)
                        <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 p-4">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-amber-800">
                                    <strong class="font-semibold">Biaya Kegiatan:</strong>
                                    <p class="mt-1">Rp {{ number_format($activity->registration_fee, 0, ',', '.') }} per peserta. Total biaya akan dihitung berdasarkan jumlah peserta yang didaftarkan.</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="grid gap-4 sm:grid-cols-3 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Jumlah Peserta <span class="text-red-600">*</span></label>
                                <input type="number" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('jumlah_peserta') border-red-500 @enderror" 
                                       name="jumlah_peserta" 
                                       id="jumlah_peserta"
                                       value="{{ old('jumlah_peserta', 0) }}" 
                                       min="0" 
                                       required
                                       placeholder="0"
                                       onchange="calculateTotal()">
                                @error('jumlah_peserta')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">Total semua peserta</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Kepala Sekolah <span class="text-red-600">*</span></label>
                                <input type="number" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('jumlah_kepala_sekolah') border-red-500 @enderror" 
                                       name="jumlah_kepala_sekolah" 
                                       id="jumlah_kepala_sekolah"
                                       value="{{ old('jumlah_kepala_sekolah', 0) }}" 
                                       min="0" 
                                       required
                                       placeholder="0"
                                       onchange="calculateTotal()">
                                @error('jumlah_kepala_sekolah')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">Berapa orang</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Guru <span class="text-red-600">*</span></label>
                                <input type="number" 
                                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('jumlah_guru') border-red-500 @enderror" 
                                       name="jumlah_guru" 
                                       id="jumlah_guru"
                                       value="{{ old('jumlah_guru', 0) }}" 
                                       min="0" 
                                       required
                                       placeholder="0"
                                       onchange="calculateTotal()">
                                @error('jumlah_guru')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">Berapa orang</p>
                            </div>
                        </div>

                        @if($activity->registration_fee > 0)
                        <div class="rounded-lg border-2 border-sky-300 bg-gradient-to-br from-sky-50 to-blue-50 p-5 mb-4 shadow-sm">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="h-5 w-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <h6 class="text-sm font-semibold text-sky-900">Estimasi Biaya Total:</h6>
                            </div>
                            <h3 class="text-2xl font-bold text-sky-700 mb-2" id="total-biaya">Rp 0</h3>
                            <p class="text-xs text-sky-800">Total biaya = Jumlah peserta × Rp {{ number_format($activity->registration_fee, 0, ',', '.') }}</p>
                        </div>
                        @endif

                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-slate-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <div class="text-sm text-slate-700">
                                    <strong class="font-semibold">ℹ️ Pendaftaran Per Sekolah</strong>
                                    <p class="mt-1">Sistem ini adalah pendaftaran per sekolah. Anda dapat mendaftarkan beberapa peserta (kepala sekolah dan guru) dari sekolah Anda dalam satu pendaftaran. Pembayaran akan dihitung berdasarkan total peserta yang didaftarkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex gap-3 justify-end border-t border-slate-200">
                    <button type="button" @click.stop="showRegistrationModal = false" class="inline-flex items-center rounded-lg bg-white border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- End Modal Form Pendaftaran -->

</div>
<!-- End x-data container -->

<script>
// Calculate total function
window.calculateTotal = function() {
    const biayaPerPeserta = {{ $activity->registration_fee }};
    const jumlahPeserta = parseInt(document.getElementById('jumlah_peserta').value) || 0;
    const jumlahKepalaSekolah = parseInt(document.getElementById('jumlah_kepala_sekolah').value) || 0;
    const jumlahGuru = parseInt(document.getElementById('jumlah_guru').value) || 0;
    
    const totalPeserta = jumlahPeserta > 0 ? jumlahPeserta : (jumlahKepalaSekolah + jumlahGuru);
    const totalBiaya = totalPeserta * biayaPerPeserta;
    
    const totalBiayaElement = document.getElementById('total-biaya');
    if (totalBiayaElement) {
        totalBiayaElement.textContent = 'Rp ' + totalBiaya.toLocaleString('id-ID');
    }
};

// Calculate on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>
@endsection

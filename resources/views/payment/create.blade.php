@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
@php
    $totalPeserta = $registration->jumlah_peserta > 0
        ? $registration->jumlah_peserta
        : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru);
    $totalBiaya = $registration->calculateTotalPayment();
@endphp

<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4 space-y-6">
        <div class="flex items-center justify-between gap-3 pt-2">
            <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke daftar kegiatan
            </a>
        </div>

        @if(session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
            <div class="space-y-6">
                <div class="rounded-2xl bg-gradient-to-r from-sky-600 to-blue-600 px-6 py-8 text-white shadow-md">
                    <h1 class="text-3xl font-bold mb-2">Upload Bukti Pembayaran</h1>
                    <p class="text-sky-100">Selesaikan pembayaran untuk pendaftaran kegiatan Anda</p>
                </div>

                <form action="{{ route('payment.store', $registration) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                        <div class="border-b border-slate-100 bg-slate-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-slate-900">Informasi Pembayaran</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Bukti Transfer <span class="text-red-600">*</span></label>
                                    <input type="file" name="proof_file" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('proof_file') border-red-500 @enderror" accept="image/*" required>
                                    @error('proof_file')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG (Max: 2MB)</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Transfer <span class="text-red-600">*</span></label>
                                    <input type="number" name="amount" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('amount') border-red-500 @enderror" value="{{ old('amount', $totalBiaya) }}" min="0" step="1" required>
                                    @error('amount')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Transfer <span class="text-red-600">*</span></label>
                                    <input type="date" name="payment_date" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('payment_date') border-red-500 @enderror" value="{{ old('payment_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                                    @error('payment_date')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor yang Bisa Dihubungi <span class="text-red-600">*</span></label>
                                    <input type="tel" name="contact_number" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('contact_number') border-red-500 @enderror" value="{{ old('contact_number', $registration->nomor_telp) }}" placeholder="Contoh: 081234567890" required>
                                    @error('contact_number')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($registration->jumlah_kepala_sekolah > 0)
                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                        <div class="border-b border-slate-100 bg-emerald-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-slate-900">
                                Data Kepala Sekolah
                                <span class="ml-2 inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-800">{{ $registration->jumlah_kepala_sekolah }} Kepala Sekolah</span>
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">
                                <div class="flex items-start gap-2">
                                    <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <strong>Data dari pendaftaran:</strong> {{ $registration->nama_kepala_sekolah }}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Surat Tugas Kepala Sekolah <span class="text-red-600">*</span></label>
                                <input type="file" name="surat_tugas_kepala_sekolah" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('surat_tugas_kepala_sekolah') border-red-500 @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                @error('surat_tugas_kepala_sekolah')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">Upload surat tugas untuk {{ $registration->nama_kepala_sekolah }}. Format: PDF, JPG, PNG (Max: 2MB)</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($registration->jumlah_guru > 0)
                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                        <div class="border-b border-slate-100 bg-sky-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-slate-900">
                                Data Guru Peserta
                                <span class="ml-2 inline-flex rounded-full bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-800">{{ $registration->jumlah_guru }} Guru</span>
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">
                                <div class="flex items-start gap-2">
                                    <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <strong>Informasi:</strong> Silakan lengkapi data untuk <strong>{{ $registration->jumlah_guru }} guru</strong> yang akan mengikuti kegiatan ini.
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @for($i = 0; $i < $registration->jumlah_guru; $i++)
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <h4 class="mb-4 text-sm font-semibold text-slate-900">Guru {{ $i + 1 }}</h4>
                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-600">*</span></label>
                                            <input type="text" name="teachers[{{ $i }}][nama_lengkap]" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error("teachers.$i.nama_lengkap") border-red-500 @enderror" value="{{ old("teachers.$i.nama_lengkap") }}" placeholder="Nama lengkap guru" required>
                                            @error("teachers.$i.nama_lengkap")
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIK</label>
                                            <input type="text" name="teachers[{{ $i }}][nik]" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error("teachers.$i.nik") border-red-500 @enderror" value="{{ old("teachers.$i.nik") }}" maxlength="16" pattern="[0-9]{16}" placeholder="Nomor Induk Kependudukan 16 digit">
                                            @error("teachers.$i.nik")
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-xs text-slate-500">16 digit NIK (opsional)</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                            <input type="email" name="teachers[{{ $i }}][email]" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error("teachers.$i.email") border-red-500 @enderror" value="{{ old("teachers.$i.email") }}" placeholder="email@example.com">
                                            @error("teachers.$i.email")
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Surat Tugas</label>
                                            <input type="file" name="teachers[{{ $i }}][surat_tugas]" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error("teachers.$i.surat_tugas") border-red-500 @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                            @error("teachers.$i.surat_tugas")
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-xs text-slate-500">Format: PDF, JPG, PNG (Max: 2MB)</p>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-6 py-5">
                        <div class="flex items-start gap-3">
                            <svg class="h-6 w-6 text-amber-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div class="text-amber-900">
                                <strong class="block text-lg mb-3">Perhatian Penting</strong>
                                <ul class="space-y-2 text-sm">
                                    <li class="flex items-start gap-2"><span class="text-amber-600 mt-0.5">•</span><span>Pastikan bukti transfer yang diupload jelas dan dapat dibaca</span></li>
                                    <li class="flex items-start gap-2"><span class="text-amber-600 mt-0.5">•</span><span>Pembayaran untuk <strong>{{ $registration->nama_sekolah }}</strong> dengan total <strong>{{ $totalPeserta }} peserta</strong></span></li>
                                    <li class="flex items-start gap-2"><span class="text-amber-600 mt-0.5">•</span><span>Total yang harus dibayar: <strong class="text-amber-800">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</strong></span></li>
                                    @if($registration->jumlah_guru > 0)
                                    <li class="flex items-start gap-2"><span class="text-amber-600 mt-0.5">•</span><span>Lengkapi data <strong>{{ $registration->jumlah_guru }} guru</strong> yang akan mengikuti kegiatan</span></li>
                                    @endif
                                    <li class="flex items-start gap-2"><span class="text-amber-600 mt-0.5">•</span><span>Pembayaran akan divalidasi oleh admin</span></li>
                                    <li class="flex items-start gap-2"><span class="text-amber-600 mt-0.5">•</span><span>Sekolah Anda akan menjadi peserta setelah pembayaran divalidasi</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Upload Bukti Pembayaran
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-4">
                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b border-slate-100 bg-gradient-to-r from-sky-50 to-blue-50 px-6 py-4">
                        <h3 class="text-lg font-semibold text-slate-900">Rincian Pembayaran Sekolah</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-2 text-sm text-slate-700">
                            <div class="flex justify-between">
                                <span>Biaya per Peserta</span>
                                <span class="font-semibold text-slate-900">Rp {{ number_format($registration->activity->registration_fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jumlah Kepala Sekolah</span>
                                <span class="text-slate-900">{{ $registration->jumlah_kepala_sekolah }} orang</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jumlah Guru</span>
                                <span class="text-slate-900">{{ $registration->jumlah_guru }} orang</span>
                            </div>
                            <div class="flex justify-between border-t border-slate-100 pt-2">
                                <span class="font-semibold text-slate-900">Total Peserta</span>
                                <span class="font-semibold text-slate-900">{{ $totalPeserta }} orang</span>
                            </div>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-sky-50 to-blue-50 px-4 py-4 border-2 border-sky-300">
                            <div class="text-sm font-semibold text-sky-600 uppercase tracking-wide">Total Pembayaran</div>
                            <div class="mt-2 text-3xl font-bold text-sky-700">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-blue-200 bg-blue-50 px-6 py-5">
                    <div class="flex items-start gap-3 mb-4">
                        <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-lg font-semibold text-blue-900">Informasi Kegiatan</h2>
                    </div>
                    <dl class="grid gap-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="font-semibold text-blue-700">Kegiatan</dt>
                            <dd class="text-blue-900 text-right">{{ $registration->activity->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-semibold text-blue-700">Program</dt>
                            <dd class="text-blue-900 text-right">{{ $registration->activity->program->name ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-semibold text-blue-700">Biaya per Peserta</dt>
                            <dd class="text-blue-900 text-right">
                                @if($registration->activity->registration_fee > 0)
                                    Rp {{ number_format($registration->activity->registration_fee, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b border-slate-100 bg-slate-50 px-6 py-4">
                        <h3 class="text-lg font-semibold text-slate-900">Data Sekolah</h3>
                    </div>
                    <div class="p-6 text-sm text-slate-800 space-y-3">
                        <div class="flex justify-between">
                            <span class="font-semibold text-slate-700">Nama Sekolah</span>
                            <span class="text-right">{{ $registration->nama_sekolah }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-slate-700">Kepala Sekolah</span>
                            <span class="text-right">{{ $registration->nama_kepala_sekolah }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-slate-700">Alamat</span>
                            <span class="text-right">{{ $registration->alamat_sekolah }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-slate-700">Provinsi</span>
                            <span class="text-right">{{ $registration->provinsi }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-slate-700">Kab/Kota</span>
                            <span class="text-right">{{ $registration->kab_kota }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-slate-700">Kecamatan</span>
                            <span class="text-right">{{ $registration->kecamatan ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-slate-700">NIK Kepala Sekolah</span>
                            <span class="text-right">{{ $registration->nik_kepala_sekolah }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

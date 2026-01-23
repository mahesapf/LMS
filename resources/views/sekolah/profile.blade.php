@extends('layouts.sekolah')

@section('title', 'Profil Sekolah')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-semibold">Periksa kembali data yang kamu input.</p>
        </div>
    @endif

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Informasi sekolah</p>
                    <h2 class="mt-1 text-xl font-semibold text-slate-900">Data profil</h2>
                </div>
                <span class="inline-flex items-center rounded-full bg-[#0284c7] px-2.5 py-0.5 text-xs font-semibold text-white">Live</span>
            </div>

            <form method="POST" action="{{ route('sekolah.profile.update') }}" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Nama Sekolah</label>
                        <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700" value="{{ $user->nama_sekolah ?? $user->name }}" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">NPSN</label>
                        <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700" value="{{ $user->npsn }}" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Provinsi</label>
                        <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700" value="{{ $user->provinsi ?? $user->province }}" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" class="mt-2 w-full rounded-lg border px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 @error('kabupaten') border-rose-300 bg-rose-50 @else border-slate-200 @enderror" value="{{ old('kabupaten', $user->kabupaten ?? $user->kabupaten_kota ?? $user->city) }}" required>
                        @error('kabupaten')
                            <p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Nama Kepala Sekolah</label>
                        <input type="text" name="nama_kepala_sekolah" class="mt-2 w-full rounded-lg border px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 @error('nama_kepala_sekolah') border-rose-300 bg-rose-50 @else border-slate-200 @enderror" value="{{ old('nama_kepala_sekolah', $user->nama_kepala_sekolah) }}" required>
                        @error('nama_kepala_sekolah')
                            <p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Email</label>
                        <input type="email" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700" value="{{ $user->email_belajar_id ?? $user->email_belajar ?? $user->email }}" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">No WhatsApp</label>
                        <input type="text" name="no_wa" class="mt-2 w-full rounded-lg border px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 @error('no_wa') border-rose-300 bg-rose-50 @else border-slate-200 @enderror" value="{{ old('no_wa', $user->no_wa ?? $user->no_hp) }}" required>
                        @error('no_wa')
                            <p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Nama Pendaftar</label>
                        <input type="text" name="pendaftar" class="mt-2 w-full rounded-lg border px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 @error('pendaftar') border-rose-300 bg-rose-50 @else border-slate-200 @enderror" value="{{ old('pendaftar', $user->nama_pendaftar ?? $user->pendaftar) }}" required>
                        @error('pendaftar')
                            <p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Jabatan Pendaftar</label>
                        <select name="jabatan_pendaftar" class="mt-2 w-full rounded-lg border px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 @error('jabatan_pendaftar') border-rose-300 bg-rose-50 @else border-slate-200 @enderror" required>
                            <option value="">Pilih Jabatan</option>
                            <option value="Wakasek Kurikulum" {{ old('jabatan_pendaftar', $user->jabatan_pendaftar) == 'Wakasek Kurikulum' ? 'selected' : '' }}>Wakasek Kurikulum</option>
                            <option value="Wakasek Humas Hubin" {{ old('jabatan_pendaftar', $user->jabatan_pendaftar) == 'Wakasek Humas Hubin' ? 'selected' : '' }}>Wakasek Humas Hubin</option>
                            <option value="Lainnya" {{ old('jabatan_pendaftar', $user->jabatan_pendaftar) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jabatan_pendaftar')
                            <p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                    <span class="text-slate-500">Tanggal daftar:</span>
                    <span class="font-semibold text-slate-900">{{ $user->created_at->format('d M Y H:i') }}</span>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-[#0284c7] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1] focus:outline-none focus:ring-2 focus:ring-[#0284c7]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Status akun</p>
                    <h3 class="mt-1 text-xl font-semibold text-slate-900">Ringkasan</h3>
                </div>
                <span class="inline-flex items-center rounded-full bg-[#0284c7] px-2.5 py-0.5 text-xs font-semibold text-white">Info</span>
            </div>

            <div class="mt-5 space-y-3">
                <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status Approval</p>
                    <div class="mt-2">
                        @if($user->approval_status == 'approved')
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-emerald-700">Status</span>
                                    <span class="text-[10px] text-emerald-600">Disetujui</span>
                                </div>
                            </div>
                        @elseif($user->approval_status == 'pending')
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-amber-700">Status</span>
                                    <span class="text-[10px] text-amber-600">Menunggu</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-rose-700">Status</span>
                                    <span class="text-[10px] text-rose-600">Ditolak</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status Akun</p>
                    <div class="mt-2">
                        @if($user->status == 'active')
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-emerald-700">Status</span>
                                    <span class="text-[10px] text-emerald-600">Aktif</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-700">Status</span>
                                    <span class="text-[10px] text-slate-600">Tidak Aktif</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($user->approved_at)
                <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Disetujui Pada</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900">{{ $user->approved_at->format('d M Y H:i') }}</p>
                </div>
                @endif

                @if($user->sk_pendaftar)
                <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">SK Pendaftar</p>
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $user->sk_pendaftar) }}" target="_blank" class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                            Lihat SK
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

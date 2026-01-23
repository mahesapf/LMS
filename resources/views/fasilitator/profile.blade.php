@extends('layouts.dashboard')

@section('title', 'Edit Biodata')

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="space-y-2">
        <h1 class="text-2xl font-semibold text-slate-900">Edit Biodata</h1>
        <p class="text-sm text-slate-600">Perbarui informasi akun dan biodata Anda</p>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2500)" x-show="show" x-transition class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 shadow-sm">
        <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </span>
        <div class="flex-1 text-sm font-semibold">{{ session('success') }}</div>
    </div>
    @endif

    <div class="grid gap-6 md:grid-cols-3">
        <!-- Form Card -->
        <div class="md:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Informasi Profil</h2>
            <form method="POST" action="{{ route('fasilitator.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" value="{{ $user->email }}" class="mt-1 block w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2 text-sm text-slate-600" disabled>
                        <p class="mt-1 text-xs text-slate-500">Email tidak dapat diubah</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nomor HP (WA) <span class="text-red-500">*</span></label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="08xxxxxxxxxx" required>
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap (dengan gelar) <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="Contoh: Dr. Ahmad Budiman, S.Pd., M.Pd." required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">NIP</label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip', $user->nip) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('nip') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="NIP">
                        @error('nip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">NIK</label>
                        <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}" maxlength="16" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('nik') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="NIK 16 digit">
                        @error('nik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tempat Lahir</label>
                        <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('birth_place') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="Kota/Kabupaten">
                        @error('birth_place')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('birth_date') border-red-300 text-red-900 focus:ring-red-500 @enderror">
                        @error('birth_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
                        <select id="gender" name="gender" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-300 text-red-900 focus:ring-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Pendidikan Terakhir</label>
                        <input type="text" id="last_education" name="last_education" value="{{ old('last_education', $user->last_education) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('last_education') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="Contoh: S1, S2, S3">
                        @error('last_education')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Jurusan</label>
                        <input type="text" id="major" name="major" value="{{ old('major', $user->major) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('major') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="Contoh: Pendidikan Matematika, Teknik Informatika">
                        @error('major')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Instansi/Sekolah/Lembaga</label>
                        <input type="text" id="institution" name="institution" value="{{ old('institution', $user->institution) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('institution') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="Nama Instansi/Sekolah/Lembaga">
                        @error('institution')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                        <input type="text" id="position" name="position" value="{{ old('position', $user->position) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('position') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="Contoh: Dosen, Guru, Widyaiswara">
                        @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email belajar.id</label>
                        <input type="email" id="email_belajar" name="email_belajar" value="{{ old('email_belajar', $user->email_belajar) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('email_belajar') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="nama@belajar.id">
                        @error('email_belajar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Foto</label>
                        @if($user->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" class="h-24 w-24 rounded-lg object-cover border border-slate-200">
                        </div>
                        @endif
                        <input type="file" id="photo" name="photo" accept="image/*" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm @error('photo') border-red-300 text-red-900 @enderror">
                        <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG. Max: 2MB</p>
                        @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanda Tangan Digital</label>
                        @if($user->digital_signature)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $user->digital_signature) }}" alt="Tanda Tangan" class="h-24 w-24 rounded-lg object-contain border border-slate-200">
                        </div>
                        @endif
                        <input type="file" id="digital_signature" name="digital_signature" accept="image/*" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm @error('digital_signature') border-red-300 text-red-900 @enderror">
                        <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG. Max: 1MB</p>
                        @error('digital_signature')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0369a1]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17 6a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2h10a2 2 0 002-2V6zM6 10a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Info -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Informasi Akun</h2>
            <div class="space-y-4">
                <div>
                    <span class="text-xs text-slate-500 font-medium">Role</span>
                    <div class="mt-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-blue-700">Fasilitator</span>
                            <span class="text-[10px] text-blue-600">Pengajar</span>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="text-xs text-slate-500 font-medium">Status</span>
                    @if($user->status == 'active')
                        <div class="mt-1.5 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-emerald-700">Aktif</span>
                                <span class="text-[10px] text-emerald-600">Pengguna Aktif</span>
                            </div>
                        </div>
                    @else
                        <div class="mt-1.5 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-slate-700">Tidak Aktif</span>
                                <span class="text-[10px] text-slate-600">Nonaktif</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div>
                    <span class="text-xs text-slate-500 font-medium">Bergabung</span>
                    <div class="mt-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
                            <span class="text-[10px] text-slate-600">Tanggal Daftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

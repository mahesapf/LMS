@extends('layouts.peserta')

@section('title', 'Profil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Profil & Biodata Saya</h1>
            <p class="mt-1 text-sm text-slate-600">Kelola informasi profil dan biodata peserta</p>
        </div>
    </div>

    @if(session('success'))
    <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('peserta.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Identitas Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            Identitas Pribadi
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                                <input type="email" class="w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-2 text-slate-500" id="email" value="{{ $user->email }}" disabled>
                                <p class="mt-1 text-xs text-slate-500">Email tidak dapat diubah</p>
                            </div>

                            <div>
                                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap (dengan gelar) <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('name') border-red-500 @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name) }}"
                                       placeholder="Contoh: Dr. Ahmad Budiman, S.Pd., M.Pd." maxlength="50" required>
                                <p class="mt-1 text-xs text-slate-500">Maksimal 50 karakter</p>
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label for="npsn" class="mb-2 block text-sm font-medium text-slate-700">NPSN</label>
                                    <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('npsn') border-red-500 @enderror"
                                           id="npsn" name="npsn" value="{{ old('npsn', $user->npsn) }}"
                                           placeholder="8 digit" maxlength="8" pattern="[0-9]{8}">
                                    <p class="mt-1 text-xs text-slate-500">8 digit angka</p>
                                    @error('npsn')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nip" class="mb-2 block text-sm font-medium text-slate-700">NIP</label>
                                    <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('nip') border-red-500 @enderror"
                                           id="nip" name="nip" value="{{ old('nip', $user->nip) }}"
                                           placeholder="18 digit" maxlength="18" pattern="[0-9]{18}">
                                    <p class="mt-1 text-xs text-slate-500">18 digit angka</p>
                                    @error('nip')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="nik" class="mb-2 block text-sm font-medium text-slate-700">NIK</label>
                                <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('nik') border-red-500 @enderror"
                                       id="nik" name="nik" value="{{ old('nik', $user->nik) }}"
                                       placeholder="16 digit" maxlength="16" pattern="[0-9]{16}">
                                <p class="mt-1 text-xs text-slate-500">16 digit angka</p>
                                @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label for="birth_place" class="mb-2 block text-sm font-medium text-slate-700">Tempat Lahir</label>
                                    <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('birth_place') border-red-500 @enderror"
                                           id="birth_place" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}"
                                           placeholder="Kota/Kabupaten">
                                    @error('birth_place')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="birth_date" class="mb-2 block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                                    <input type="date" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('birth_date') border-red-500 @enderror"
                                           id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                                    @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="gender" class="mb-2 block text-sm font-medium text-slate-700">Jenis Kelamin</label>
                                <select class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('gender') border-red-500 @enderror" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kepegawaian Section -->
                    <div class="mb-6 border-t border-slate-200 pt-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                            </svg>
                            Kepegawaian
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="pns_status" class="mb-2 block text-sm font-medium text-slate-700">Status Kepegawaian</label>
                                <select class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('pns_status') border-red-500 @enderror" id="pns_status" name="pns_status">
                                    <option value="">Pilih Status</option>
                                    <option value="PNS" {{ old('pns_status', $user->pns_status) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="Non PNS" {{ old('pns_status', $user->pns_status) == 'Non PNS' ? 'selected' : '' }}>Non PNS</option>
                                </select>
                                @error('pns_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="pns-fields" class="grid gap-4 md:grid-cols-2" style="display: {{ old('pns_status', $user->pns_status) == 'PNS' ? 'grid' : 'none' }};">
                                <div>
                                    <label for="rank" class="mb-2 block text-sm font-medium text-slate-700">Pangkat</label>
                                    <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('rank') border-red-500 @enderror"
                                           id="rank" name="rank" value="{{ old('rank', $user->rank) }}"
                                           placeholder="Contoh: Penata Muda" maxlength="50">
                                    @error('rank')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="group" class="mb-2 block text-sm font-medium text-slate-700">Golongan</label>
                                    <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('group') border-red-500 @enderror"
                                           id="group" name="group" value="{{ old('group', $user->group) }}"
                                           placeholder="Contoh: III/a" maxlength="10">
                                    @error('group')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="position_type" class="mb-2 block text-sm font-medium text-slate-700">Jabatan</label>
                                <select class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('position_type') border-red-500 @enderror" id="position_type" name="position_type">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Guru" {{ old('position_type', $user->position_type) == 'Guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="Kepala Sekolah" {{ old('position_type', $user->position_type) == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                    <option value="Lainnya" {{ old('position_type', $user->position_type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('position_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="position-detail" style="display: {{ old('position_type', $user->position_type) == 'Lainnya' ? 'block' : 'none' }};">
                                <label for="position" class="mb-2 block text-sm font-medium text-slate-700">Detail Jabatan</label>
                                <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('position') border-red-500 @enderror"
                                       id="position" name="position" value="{{ old('position', $user->position) }}"
                                       placeholder="Sebutkan jabatan Anda" maxlength="100">
                                @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="institution" class="mb-2 block text-sm font-medium text-slate-700">Instansi/Sekolah/Lembaga</label>
                                <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('institution') border-red-500 @enderror"
                                       id="institution" name="institution" value="{{ old('institution', $user->institution) }}"
                                       placeholder="Nama Instansi/Sekolah/Lembaga" maxlength="50">
                                @error('institution')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pendidikan Section -->
                    <div class="mb-6 border-t border-slate-200 pt-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                            </svg>
                            Pendidikan
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="last_education" class="mb-2 block text-sm font-medium text-slate-700">Pendidikan Terakhir</label>
                                <select class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('last_education') border-red-500 @enderror"
                                        id="last_education" name="last_education">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <option value="SMA/SMK" {{ old('last_education', $user->last_education) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                    <option value="D3" {{ old('last_education', $user->last_education) == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ old('last_education', $user->last_education) == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('last_education', $user->last_education) == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('last_education', $user->last_education) == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                                @error('last_education')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="major" class="mb-2 block text-sm font-medium text-slate-700">Jurusan</label>
                                <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('major') border-red-500 @enderror"
                                       id="major" name="major" value="{{ old('major', $user->major) }}"
                                       placeholder="Contoh: Pendidikan Matematika" maxlength="50">
                                @error('major')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Section -->
                    <div class="mb-6 border-t border-slate-200 pt-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            Kontak
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">Nomor HP (WA) <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('phone') border-red-500 @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                       placeholder="08xxxxxxxxxx" maxlength="16" pattern="[0-9]{10,16}" required>
                                <p class="mt-1 text-xs text-slate-500">10-16 digit angka</p>
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email_belajar" class="mb-2 block text-sm font-medium text-slate-700">Email belajar.id</label>
                                <input type="email" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('email_belajar') border-red-500 @enderror"
                                       id="email_belajar" name="email_belajar" value="{{ old('email_belajar', $user->email_belajar) }}"
                                       placeholder="nama@belajar.id" maxlength="50">
                                @error('email_belajar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="mb-2 block text-sm font-medium text-slate-700">Alamat</label>
                                <textarea class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('address') border-red-500 @enderror"
                                          id="address" name="address" rows="3" placeholder="Alamat lengkap" maxlength="100">{{ old('address', $user->address) }}</textarea>
                                <p class="mt-1 text-xs text-slate-500">Maksimal 100 karakter</p>
                                @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="province" class="mb-2 block text-sm font-medium text-slate-700">Provinsi</label>
                                <select class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('province') border-red-500 @enderror"
                                        id="province" name="province">
                                    <option value="">Pilih Provinsi</option>
                                    @if(old('province', $user->province))
                                    <option value="{{ old('province', $user->province) }}" selected>{{ old('province', $user->province) }}</option>
                                    @endif
                                </select>
                                @error('province')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label for="city" class="mb-2 block text-sm font-medium text-slate-700">Kabupaten/Kota</label>
                                    <select class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('city') border-red-500 @enderror"
                                            id="city" name="city" disabled>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        @if(old('city', $user->city))
                                        <option value="{{ old('city', $user->city) }}" selected>{{ old('city', $user->city) }}</option>
                                        @endif
                                    </select>
                                    @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="district" class="mb-2 block text-sm font-medium text-slate-700">Kecamatan</label>
                                    <select class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('district') border-red-500 @enderror"
                                            id="district" name="district" disabled>
                                        <option value="">Pilih Kecamatan</option>
                                        @if(old('district', $user->district))
                                        <option value="{{ old('district', $user->district) }}" selected>{{ old('district', $user->district) }}</option>
                                        @endif
                                    </select>
                                    @error('district')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Section -->
                    <div class="mb-6 border-t border-slate-200 pt-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                            Dokumen
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="photo" class="mb-2 block text-sm font-medium text-slate-700">Foto</label>
                                @if($user->photo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" class="h-32 w-32 rounded-lg border-2 border-slate-200 object-cover">
                                </div>
                                @endif
                                <input type="file" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('photo') border-red-500 @enderror"
                                       id="photo" name="photo" accept="image/*">
                                <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG. Max: 2MB</p>
                                @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="digital_signature" class="mb-2 block text-sm font-medium text-slate-700">Tanda Tangan Digital</label>
                                @if($user->digital_signature)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $user->digital_signature) }}" alt="Tanda Tangan" class="h-24 w-32 rounded-lg border-2 border-slate-200 object-contain bg-white">
                                </div>
                                @endif
                                <input type="file" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('digital_signature') border-red-500 @enderror"
                                       id="digital_signature" name="digital_signature" accept="image/*">
                                <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG. Max: 1MB</p>
                                @error('digital_signature')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-6 py-2.5 font-semibold text-white shadow-sm transition hover:bg-sky-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Akun</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-slate-500">Role</p>
                        <span class="mt-1 inline-flex items-center rounded-lg bg-[#0284c7] px-3 py-1 text-sm font-semibold text-white">Peserta</span>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Status Akun</p>
                        @if($user->status == 'active')
                        <span class="mt-1 inline-flex items-center rounded-lg bg-cyan-500 px-3 py-1 text-sm font-semibold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Aktif
                        </span>
                        @else
                        <span class="mt-1 inline-flex items-center rounded-lg bg-slate-500 px-3 py-1 text-sm font-semibold text-white">Tidak Aktif</span>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Bergabung Sejak</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $user->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="border-t border-slate-200 pt-4">
                        <p class="text-sm text-slate-500 mb-2">Profil Lengkap</p>
                        <div class="h-2 w-full rounded-full bg-slate-200">
                            <div class="h-2 rounded-full bg-sky-600" style="width: {{ $user->photo && $user->phone && $user->name ? '75' : '40' }}%"></div>
                        </div>
                        <p class="mt-2 text-xs text-slate-600">Lengkapi profil untuk pengalaman lebih baik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle PNS fields
        const pnsStatus = document.getElementById('pns_status');
        const pnsFields = document.getElementById('pns-fields');

        if (pnsStatus) {
            pnsStatus.addEventListener('change', function() {
                if (this.value === 'PNS') {
                    pnsFields.style.display = 'grid';
                } else {
                    pnsFields.style.display = 'none';
                }
            });
        }

        // Toggle position detail
        const positionType = document.getElementById('position_type');
        const positionDetail = document.getElementById('position-detail');

        if (positionType) {
            positionType.addEventListener('change', function() {
                if (this.value === 'Lainnya') {
                    positionDetail.style.display = 'block';
                } else {
                    positionDetail.style.display = 'none';
                }
            });
        }

        // Wilayah Indonesia API
        const API_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const districtSelect = document.getElementById('district');

        const savedProvince = '{{ old('province', $user->province ?? '') }}';
        const savedCity = '{{ old('city', $user->city ?? '') }}';
        const savedDistrict = '{{ old('district', $user->district ?? '') }}';

        // Load provinces on page load
        async function loadProvinces() {
            try {
                console.log('Loading provinces...');
                const response = await fetch(`${API_BASE}/provinces.json`);
                const provinces = await response.json();

                console.log('Provinces loaded:', provinces.length);

                provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';

                let selectedProvinceId = null;

                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.textContent = province.name;
                    option.dataset.id = province.id;

                    if (province.name === savedProvince) {
                        option.selected = true;
                        selectedProvinceId = province.id;
                    }

                    provinceSelect.appendChild(option);
                });

                // Load cities if province was saved
                if (selectedProvinceId) {
                    await loadCities(selectedProvinceId, true);
                }
            } catch (error) {
                console.error('Error loading provinces:', error);
                provinceSelect.innerHTML = '<option value="">Error: Tidak dapat memuat provinsi</option>';
            }
        }

        // Load cities
        async function loadCities(provinceId, isInitialLoad = false) {
            try {
                console.log('Loading cities for province:', provinceId);
                citySelect.disabled = true;
                citySelect.innerHTML = '<option value="">Memuat...</option>';
                districtSelect.disabled = true;
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

                const response = await fetch(`${API_BASE}/regencies/${provinceId}.json`);
                const cities = await response.json();

                console.log('Cities loaded:', cities.length);

                citySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';

                let selectedCityId = null;

                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.name;
                    option.textContent = city.name;
                    option.dataset.id = city.id;

                    if (isInitialLoad && city.name === savedCity) {
                        option.selected = true;
                        selectedCityId = city.id;
                    }

                    citySelect.appendChild(option);
                });

                citySelect.disabled = false;

                // Load districts if city was saved
                if (isInitialLoad && selectedCityId) {
                    await loadDistricts(selectedCityId, true);
                }
            } catch (error) {
                console.error('Error loading cities:', error);
                citySelect.innerHTML = '<option value="">Error: Tidak dapat memuat kab/kota</option>';
                citySelect.disabled = false;
            }
        }

        // Load districts
        async function loadDistricts(cityId, isInitialLoad = false) {
            try {
                console.log('Loading districts for city:', cityId);
                districtSelect.disabled = true;
                districtSelect.innerHTML = '<option value="">Memuat...</option>';

                const response = await fetch(`${API_BASE}/districts/${cityId}.json`);
                const districts = await response.json();

                console.log('Districts loaded:', districts.length);

                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

                districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.name;
                    option.textContent = district.name;

                    if (isInitialLoad && district.name === savedDistrict) {
                        option.selected = true;
                    }

                    districtSelect.appendChild(option);
                });

                districtSelect.disabled = false;
            } catch (error) {
                console.error('Error loading districts:', error);
                districtSelect.innerHTML = '<option value="">Error: Tidak dapat memuat kecamatan</option>';
                districtSelect.disabled = false;
            }
        }

        // Event listener for province change
        provinceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const provinceId = selectedOption.dataset.id;

            // Reset dependent selects
            citySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
            citySelect.disabled = true;
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            districtSelect.disabled = true;

            if (provinceId) {
                loadCities(provinceId);
            }
        });

        // Event listener for city change
        citySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const cityId = selectedOption.dataset.id;

            // Reset district select
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            districtSelect.disabled = true;

            if (cityId) {
                loadDistricts(cityId);
            }
        });

        // Initialize
        loadProvinces();
    });
</script>
@endpush
@endsection

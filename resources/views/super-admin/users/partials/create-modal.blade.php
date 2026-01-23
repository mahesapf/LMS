<div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="showCreateModal = false">
    <div class="fixed inset-0 bg-slate-900/70" @click="showCreateModal = false"></div>
    <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div @click.away="showCreateModal = false" class="relative w-full max-w-6xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 sticky top-0 bg-white z-10">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir</p>
                    <h2 class="text-lg font-semibold text-slate-900">Tambah Pengguna</h2>
                </div>
                <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" @click="showCreateModal = false">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.users.store') }}" enctype="multipart/form-data" x-data="{ role: '{{ old('role') }}', pnsStatus: '{{ old('pns_status') }}', positionType: '{{ old('position_type') }}' }">
                @csrf

                <div class="space-y-6 px-6 py-6">
                    {{-- Data Akun --}}
                    <div class="rounded-xl border border-[#0284c7]/20 bg-[#0284c7]/5 p-4">
                        <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#0284c7]" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                            Data Akun
                        </h3>
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                                <input type="text" name="name" maxlength="50" placeholder="Masukkan nama lengkap" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                                <p class="mt-1 text-xs text-slate-500">Maksimal 50 karakter</p>
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email <span class="text-red-600">*</span></label>
                                <input type="email" name="email" maxlength="50" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Password <span class="text-red-600">*</span></label>
                                <input type="password" name="password" minlength="8" maxlength="20" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('password') border-red-500 @enderror" required>
                                <p class="mt-1 text-xs text-slate-500">Min 8 karakter, max 20 karakter</p>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700">Role <span class="text-red-600">*</span></label>
                                <select name="role" x-model="role" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('role') border-red-500 @enderror" required>
                                    <option value="">Pilih Role</option>
                                    @if(auth()->user()->role !== 'admin')
                                    <option value="admin">Admin</option>
                                    @endif
                                    <option value="fasilitator">Fasilitator</option>
                                    <option value="peserta">Peserta</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Form khusus untuk role peserta --}}
                    <div x-show="role === 'peserta'" x-cloak>
                        {{-- Data Identitas Pribadi --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                Data Identitas Pribadi
                            </h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium text-slate-700">Email belajar.id</label>
                                    <input type="email" name="email_belajar" maxlength="50" placeholder="nama@belajar.id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('email_belajar') border-red-500 @enderror" value="{{ old('email_belajar') }}">
                                    @error('email_belajar')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NPSN</label>
                                    <input type="text" name="npsn" maxlength="8" pattern="[0-9]{8}" placeholder="8 digit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('npsn') border-red-500 @enderror" value="{{ old('npsn') }}">
                                    <p class="mt-1 text-xs text-slate-500">8 digit angka</p>
                                    @error('npsn')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NIP</label>
                                    <input type="text" name="nip" maxlength="18" pattern="[0-9]{18}" placeholder="18 digit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('nip') border-red-500 @enderror" value="{{ old('nip') }}">
                                    <p class="mt-1 text-xs text-slate-500">18 digit angka</p>
                                    @error('nip')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NIK</label>
                                    <input type="text" name="nik" maxlength="16" pattern="[0-9]{16}" placeholder="16 digit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('nik') border-red-500 @enderror" value="{{ old('nik') }}">
                                    <p class="mt-1 text-xs text-slate-500">16 digit angka</p>
                                    @error('nik')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Tempat Lahir</label>
                                    <input type="text" name="birth_place" maxlength="50" placeholder="Kota/Kabupaten" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('birth_place') border-red-500 @enderror" value="{{ old('birth_place') }}">
                                    @error('birth_place')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('birth_date') border-red-500 @enderror" value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
                                    <select name="gender" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('gender') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Data Kepegawaian --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 mt-4">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                                Data Kepegawaian
                            </h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Status Kepegawaian</label>
                                    <select name="pns_status" x-model="pnsStatus" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('pns_status') border-red-500 @enderror">
                                        <option value="">Pilih Status</option>
                                        <option value="PNS">PNS</option>
                                        <option value="Non PNS">Non PNS</option>
                                    </select>
                                    @error('pns_status')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div x-show="pnsStatus === 'PNS'">
                                    <label class="block text-sm font-medium text-slate-700">Pangkat</label>
                                    <input type="text" name="rank" maxlength="50" placeholder="Contoh: Penata Muda" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('rank') border-red-500 @enderror" value="{{ old('rank') }}">
                                    @error('rank')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div x-show="pnsStatus === 'PNS'">
                                    <label class="block text-sm font-medium text-slate-700">Golongan</label>
                                    <input type="text" name="group" maxlength="10" placeholder="Contoh: III/a" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('group') border-red-500 @enderror" value="{{ old('group') }}">
                                    @error('group')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                                    <select name="position_type" x-model="positionType" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('position_type') border-red-500 @enderror">
                                        <option value="">Pilih Jabatan</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    @error('position_type')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div x-show="positionType === 'Lainnya'" class="col-span-2">
                                    <label class="block text-sm font-medium text-slate-700">Detail Jabatan</label>
                                    <input type="text" name="position" maxlength="100" placeholder="Sebutkan jabatan Anda" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('position') border-red-500 @enderror" value="{{ old('position') }}">
                                    @error('position')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium text-slate-700">Instansi/Sekolah/Lembaga</label>
                                    <input type="text" name="institution" maxlength="50" placeholder="Nama Instansi/Sekolah/Lembaga" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('institution') border-red-500 @enderror" value="{{ old('institution') }}">
                                    @error('institution')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Data Pendidikan --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 mt-4">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                </svg>
                                Data Pendidikan
                            </h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Pendidikan Terakhir</label>
                                    <select name="last_education" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('last_education') border-red-500 @enderror">
                                        <option value="">Pilih Pendidikan Terakhir</option>
                                        <option value="SMA/SMK" {{ old('last_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                        <option value="D3" {{ old('last_education') == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="S1" {{ old('last_education') == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('last_education') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('last_education') == 'S3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                    @error('last_education')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jurusan</label>
                                    <input type="text" name="major" maxlength="50" placeholder="Contoh: Pendidikan Matematika" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('major') border-red-500 @enderror" value="{{ old('major') }}">
                                    @error('major')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Data Kontak --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 mt-4">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                Data Kontak
                            </h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Nomor HP (WA)</label>
                                    <input type="text" name="phone" maxlength="16" pattern="[0-9]{10,16}" placeholder="08xxxxxxxxxx" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('phone') border-red-500 @enderror" value="{{ old('phone') }}">
                                    <p class="mt-1 text-xs text-slate-500">10-16 digit angka</p>
                                    @error('phone')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-slate-700">Alamat</label>
                                    <textarea name="address" rows="2" maxlength="100" placeholder="Alamat lengkap" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                                    <p class="mt-1 text-xs text-slate-500">Maksimal 100 karakter</p>
                                    @error('address')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Provinsi</label>
                                    <select name="province" id="province_create" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('province') border-red-500 @enderror">
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                    @error('province')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Kabupaten/Kota</label>
                                    <select name="city" id="city_create" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('city') border-red-500 @enderror" disabled>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                    @error('city')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Kecamatan</label>
                                    <select name="district" id="district_create" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('district') border-red-500 @enderror" disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    @error('district')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Data Dokumen --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 mt-4">
                            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                                Data Dokumen
                            </h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Foto Peserta</label>
                                    <input type="file" name="photo" accept="image/*" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('photo') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG. Max: 2MB</p>
                                    @error('photo')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Tanda Tangan Digital</label>
                                    <input type="file" name="digital_signature" accept="image/*" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('digital_signature') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG. Max: 1MB</p>
                                    @error('digital_signature')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form sederhana untuk role admin & fasilitator --}}
                    <div x-show="role === 'admin' || role === 'fasilitator'" x-cloak>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Data Pribadi</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                                    <input type="text" name="name" maxlength="50" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200" value="{{ old('name') }}" x-bind:required="role !== 'peserta'">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Nomor HP</label>
                                    <input type="text" name="phone" maxlength="16" placeholder="08xxxxxxxxxx" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200" value="{{ old('phone') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sticky bottom-0 flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
                    <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100" @click="showCreateModal = false">
                        Batal
                    </button>
                    <button type="submit" class="rounded-lg bg-[#0284c7] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1]">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const API_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    const provinceSelect = document.getElementById('province_create');
    const citySelect = document.getElementById('city_create');
    const districtSelect = document.getElementById('district_create');

    if (!provinceSelect) return;

    // Load provinces
    async function loadProvinces() {
        try {
            const response = await fetch(`${API_BASE}/provinces.json`);
            const provinces = await response.json();

            provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
            provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.name;
                option.textContent = province.name;
                option.dataset.id = province.id;
                provinceSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading provinces:', error);
        }
    }

    // Load cities
    async function loadCities(provinceId) {
        try {
            citySelect.disabled = true;
            citySelect.innerHTML = '<option value="">Memuat...</option>';
            districtSelect.disabled = true;
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

            const response = await fetch(`${API_BASE}/regencies/${provinceId}.json`);
            const cities = await response.json();

            citySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
            cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.name;
                option.textContent = city.name;
                option.dataset.id = city.id;
                citySelect.appendChild(option);
            });

            citySelect.disabled = false;
        } catch (error) {
            console.error('Error loading cities:', error);
            citySelect.innerHTML = '<option value="">Error</option>';
        }
    }

    // Load districts
    async function loadDistricts(cityId) {
        try {
            districtSelect.disabled = true;
            districtSelect.innerHTML = '<option value="">Memuat...</option>';

            const response = await fetch(`${API_BASE}/districts/${cityId}.json`);
            const districts = await response.json();

            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.name;
                option.textContent = district.name;
                districtSelect.appendChild(option);
            });

            districtSelect.disabled = false;
        } catch (error) {
            console.error('Error loading districts:', error);
            districtSelect.innerHTML = '<option value="">Error</option>';
        }
    }

    // Event listeners
    provinceSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const provinceId = selectedOption.dataset.id;

        citySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        citySelect.disabled = true;
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        districtSelect.disabled = true;

        if (provinceId) {
            loadCities(provinceId);
        }
    });

    citySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const cityId = selectedOption.dataset.id;

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

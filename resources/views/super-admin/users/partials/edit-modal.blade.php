@if(isset($editUser))
<div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="showEditModal = false">
    <div class="fixed inset-0 bg-slate-900/70" @click="showEditModal = false"></div>
    <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div @click.away="showEditModal = false"
             x-data="{
                 role: '{{ old('role', $editUser->role) }}',
                 pnsStatus: '{{ old('pns_status', $editUser->pns_status) }}',
                 positionType: '{{ old('position_type', $editUser->position_type) }}'
             }"
             class="relative w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir</p>
                    <h2 class="text-lg font-semibold text-slate-900">Edit Pengguna</h2>
                </div>
                <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" @click="showEditModal = false">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.users.update', $editUser) }}" enctype="multipart/form-data" class="divide-y divide-slate-100">
                @csrf
                @method('PUT')

                <div class="space-y-6 px-6 py-6">
                    <!-- Data Akun -->
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <h3 class="text-sm font-semibold text-slate-900">Data Akun</h3>
                        <div class="mt-4 grid gap-4 sm:grid-cols-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                                <input type="text" name="name" maxlength="50" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('name') border-red-500 @enderror" value="{{ old('name', $editUser->name) }}" required>
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email <span class="text-red-600">*</span></label>
                                <input type="email" name="email" maxlength="50" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('email') border-red-500 @enderror" value="{{ old('email', $editUser->email) }}" required>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Password</label>
                                <input type="password" name="password" minlength="8" maxlength="20" placeholder="Kosongkan jika tidak diubah" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('password') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-slate-500">Min 8 karakter, max 20</p>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Role <span class="text-red-600">*</span></label>
                                <select name="role" x-model="role" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('role') border-red-500 @enderror" required>
                                    <option value="">Pilih Role</option>
                                    @if(auth()->user()->role !== 'admin')
                                    <option value="admin" {{ old('role', $editUser->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    @endif
                                    <option value="fasilitator" {{ old('role', $editUser->role) == 'fasilitator' ? 'selected' : '' }}>Fasilitator</option>
                                    <option value="peserta" {{ old('role', $editUser->role) == 'peserta' ? 'selected' : '' }}>Peserta</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form untuk Admin & Fasilitator - Simple -->
                    <div x-show="role === 'admin' || role === 'fasilitator'" class="space-y-6">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Status Akun</h3>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-slate-700">Status <span class="text-red-600">*</span></label>
                                <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('status') border-red-500 @enderror">
                                    <option value="active" {{ old('status', $editUser->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ old('status', $editUser->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="inactive" {{ old('status', $editUser->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form untuk Peserta - Lengkap -->
                    <div x-show="role === 'peserta'" class="space-y-6">
                        <!-- 1. Identitas Pribadi -->
                        <div class="rounded-xl border border-sky-200 bg-gradient-to-br from-sky-50 to-white p-4">
                            <h3 class="text-sm font-semibold text-sky-900">1. Identitas Pribadi</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Email Belajar.id</label>
                                    <input type="email" name="email_belajar" maxlength="50" placeholder="nama@belajar.id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('email_belajar') border-red-500 @enderror" value="{{ old('email_belajar', $editUser->email_belajar) }}">
                                    @error('email_belajar')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NPSN</label>
                                    <input type="text" name="npsn" maxlength="8" pattern="[0-9]{8}" placeholder="8 digit NPSN" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('npsn') border-red-500 @enderror" value="{{ old('npsn', $editUser->npsn) }}">
                                    @error('npsn')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NIP</label>
                                    <input type="text" name="nip" maxlength="18" pattern="[0-9]{18}" placeholder="18 digit NIP" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('nip') border-red-500 @enderror" value="{{ old('nip', $editUser->nip) }}">
                                    @error('nip')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NIK</label>
                                    <input type="text" name="nik" maxlength="16" pattern="[0-9]{16}" placeholder="16 digit NIK" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('nik') border-red-500 @enderror" value="{{ old('nik', $editUser->nik) }}">
                                    @error('nik')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Tempat Lahir</label>
                                    <input type="text" name="birth_place" maxlength="50" placeholder="Kota/Kabupaten" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('birth_place') border-red-500 @enderror" value="{{ old('birth_place', $editUser->birth_place) }}">
                                    @error('birth_place')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('birth_date') border-red-500 @enderror" value="{{ old('birth_date', $editUser->birth_date) }}">
                                    @error('birth_date')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
                                    <select name="gender" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('gender') border-red-500 @enderror">
                                        <option value="">Pilih</option>
                                        <option value="L" {{ old('gender', $editUser->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender', $editUser->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 2. Data Kepegawaian -->
                        <div class="rounded-xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-white p-4">
                            <h3 class="text-sm font-semibold text-emerald-900">2. Data Kepegawaian</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Status PNS</label>
                                    <select name="pns_status" x-model="pnsStatus" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 @error('pns_status') border-red-500 @enderror">
                                        <option value="">Pilih Status</option>
                                        <option value="PNS" {{ old('pns_status', $editUser->pns_status) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                        <option value="Non PNS" {{ old('pns_status', $editUser->pns_status) == 'Non PNS' ? 'selected' : '' }}>Non PNS</option>
                                    </select>
                                    @error('pns_status')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div x-show="pnsStatus === 'PNS'">
                                    <label class="block text-sm font-medium text-slate-700">Pangkat</label>
                                    <input type="text" name="rank" maxlength="50" placeholder="Pembina" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 @error('rank') border-red-500 @enderror" value="{{ old('rank', $editUser->rank) }}">
                                    @error('rank')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div x-show="pnsStatus === 'PNS'">
                                    <label class="block text-sm font-medium text-slate-700">Golongan</label>
                                    <input type="text" name="group" maxlength="10" placeholder="IV/a" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 @error('group') border-red-500 @enderror" value="{{ old('group', $editUser->group) }}">
                                    @error('group')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jenis Jabatan</label>
                                    <select name="position_type" x-model="positionType" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 @error('position_type') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Jabatan</option>
                                        <option value="Guru" {{ old('position_type', $editUser->position_type) == 'Guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="Kepala Sekolah" {{ old('position_type', $editUser->position_type) == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                        <option value="Lainnya" {{ old('position_type', $editUser->position_type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('position_type')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div x-show="positionType === 'Lainnya'">
                                    <label class="block text-sm font-medium text-slate-700">Detail Jabatan</label>
                                    <input type="text" name="position" maxlength="100" placeholder="Tulis jabatan Anda" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 @error('position') border-red-500 @enderror" value="{{ old('position', $editUser->position) }}">
                                    @error('position')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Instansi/Nama Sekolah</label>
                                    <input type="text" name="institution" maxlength="50" placeholder="Nama instansi" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 @error('institution') border-red-500 @enderror" value="{{ old('institution', $editUser->institution) }}">
                                    @error('institution')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 3. Riwayat Pendidikan -->
                        <div class="rounded-xl border border-purple-200 bg-gradient-to-br from-purple-50 to-white p-4">
                            <h3 class="text-sm font-semibold text-purple-900">3. Riwayat Pendidikan</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Pendidikan Terakhir</label>
                                    <select name="last_education" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error('last_education') border-red-500 @enderror">
                                        <option value="">Pilih Jenjang</option>
                                        <option value="SMA/SMK" {{ old('last_education', $editUser->last_education) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                        <option value="D3" {{ old('last_education', $editUser->last_education) == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="S1" {{ old('last_education', $editUser->last_education) == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('last_education', $editUser->last_education) == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('last_education', $editUser->last_education) == 'S3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                    @error('last_education')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jurusan/Program Studi</label>
                                    <input type="text" name="major" maxlength="50" placeholder="Contoh: Pendidikan Matematika" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 @error('major') border-red-500 @enderror" value="{{ old('major', $editUser->major) }}">
                                    @error('major')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 4. Kontak & Alamat -->
                        <div class="rounded-xl border border-amber-200 bg-gradient-to-br from-amber-50 to-white p-4">
                            <h3 class="text-sm font-semibold text-amber-900">4. Kontak & Alamat</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">No HP/WA</label>
                                    <input type="text" name="phone" maxlength="16" pattern="[0-9]{10,16}" placeholder="08xxxxxxxxxx" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 @error('phone') border-red-500 @enderror" value="{{ old('phone', $editUser->phone) }}">
                                    @error('phone')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700">Alamat Lengkap</label>
                                    <input type="text" name="address" maxlength="100" placeholder="Jalan, RT/RW, Kelurahan" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 @error('address') border-red-500 @enderror" value="{{ old('address', $editUser->address) }}">
                                    @error('address')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Provinsi</label>
                                    <select name="province" id="province_edit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 @error('province') border-red-500 @enderror">
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                    @error('province')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Kabupaten/Kota</label>
                                    <select name="city" id="city_edit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 @error('city') border-red-500 @enderror">
                                        <option value="">Pilih Kab/Kota</option>
                                    </select>
                                    @error('city')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Kecamatan</label>
                                    <select name="district" id="district_edit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 @error('district') border-red-500 @enderror">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    @error('district')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 5. Upload Dokumen -->
                        <div class="rounded-xl border border-rose-200 bg-gradient-to-br from-rose-50 to-white p-4">
                            <h3 class="text-sm font-semibold text-rose-900">5. Upload Dokumen</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Foto 3x4</label>
                                    @if($editUser->photo)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($editUser->photo) }}" alt="Foto" class="h-32 w-24 rounded-lg border-2 border-slate-200 object-cover">
                                            <p class="mt-1 text-xs text-slate-600">File saat ini</p>
                                        </div>
                                    @endif
                                    <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg" class="mt-1 w-full rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm hover:border-rose-400 focus:border-rose-500 focus:ring-2 focus:ring-rose-200 @error('photo') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-slate-500">JPG/PNG, Max 2MB</p>
                                    @error('photo')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Tanda Tangan Digital</label>
                                    @if($editUser->digital_signature)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($editUser->digital_signature) }}" alt="TTD" class="h-20 w-32 rounded-lg border-2 border-slate-200 bg-white object-contain p-2">
                                            <p class="mt-1 text-xs text-slate-600">File saat ini</p>
                                        </div>
                                    @endif
                                    <input type="file" name="digital_signature" accept="image/png" class="mt-1 w-full rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm hover:border-rose-400 focus:border-rose-500 focus:ring-2 focus:ring-rose-200 @error('digital_signature') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-slate-500">PNG, Max 1MB</p>
                                    @error('digital_signature')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status Akun untuk Peserta -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Status Akun</h3>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-slate-700">Status <span class="text-red-600">*</span></label>
                                <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('status') border-red-500 @enderror">
                                    <option value="active" {{ old('status', $editUser->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ old('status', $editUser->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="inactive" {{ old('status', $editUser->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
                    <button type="button" @click="showEditModal = false" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0369a1] transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province_edit');
    const citySelect = document.getElementById('city_edit');
    const districtSelect = document.getElementById('district_edit');

    if (!provinceSelect) return;

    // Load provinces
    async function loadProvinces() {
        try {
            const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
            const provinces = await response.json();

            provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
            provinces.forEach(province => {
                const option = new Option(province.name, province.name);
                option.dataset.id = province.id;
                provinceSelect.appendChild(option);
            });

            // Set existing province
            const savedProvince = "{{ old('province', $editUser->province ?? '') }}";
            if (savedProvince) {
                provinceSelect.value = savedProvince;
                const selectedOption = provinceSelect.options[provinceSelect.selectedIndex];
                if (selectedOption && selectedOption.dataset.id) {
                    await loadCities(selectedOption.dataset.id);
                }
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
            provinceSelect.innerHTML = '<option value="">Error loading provinces</option>';
        }
    }

    // Load cities based on province
    async function loadCities(provinceId) {
        try {
            citySelect.innerHTML = '<option value="">Memuat...</option>';
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

            const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`);
            const cities = await response.json();

            citySelect.innerHTML = '<option value="">Pilih Kab/Kota</option>';
            cities.forEach(city => {
                const option = new Option(city.name, city.name);
                option.dataset.id = city.id;
                citySelect.appendChild(option);
            });

            // Set existing city
            const savedCity = "{{ old('city', $editUser->city ?? '') }}";
            if (savedCity) {
                citySelect.value = savedCity;
                const selectedOption = citySelect.options[citySelect.selectedIndex];
                if (selectedOption && selectedOption.dataset.id) {
                    await loadDistricts(selectedOption.dataset.id);
                }
            }
        } catch (error) {
            console.error('Error loading cities:', error);
            citySelect.innerHTML = '<option value="">Error loading cities</option>';
        }
    }

    // Load districts based on city
    async function loadDistricts(cityId) {
        try {
            districtSelect.innerHTML = '<option value="">Memuat...</option>';

            const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`);
            const districts = await response.json();

            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            districts.forEach(district => {
                districtSelect.appendChild(new Option(district.name, district.name));
            });

            // Set existing district
            const savedDistrict = "{{ old('district', $editUser->district ?? '') }}";
            if (savedDistrict) {
                districtSelect.value = savedDistrict;
            }
        } catch (error) {
            console.error('Error loading districts:', error);
            districtSelect.innerHTML = '<option value="">Error loading districts</option>';
        }
    }

    // Event listeners
    provinceSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.id) {
            loadCities(selectedOption.dataset.id);
        } else {
            citySelect.innerHTML = '<option value="">Pilih Kab/Kota</option>';
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        }
    });

    citySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.id) {
            loadDistricts(selectedOption.dataset.id);
        } else {
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        }
    });

    // Initialize
    loadProvinces();
});
</script>
@endpush

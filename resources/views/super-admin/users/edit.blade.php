{{-- Modal content now in index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Edit Pengguna')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<script>
    window.location.href = "{{ route('super-admin.users') }}?edit={{ $user->id }}";
</script>
@endsection
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir</p>
                        <h2 class="text-lg font-semibold text-slate-900">Edit Pengguna</h2>
                    </div>
                    <button class="rounded-md p-2 text-slate-500 hover:bg-slate-100" @click="open = false">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('super-admin.users.update', $user) }}" enctype="multipart/form-data" class="divide-y divide-slate-100">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6 px-6 py-6">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Data Akun</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Email <span class="text-red-600">*</span></label>
                                    <input type="email" name="email" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Role <span class="text-red-600">*</span></label>
                                    <select name="role" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('role') border-red-500 @enderror" required>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="fasilitator" {{ old('role', $user->role) == 'fasilitator' ? 'selected' : '' }}>Fasilitator</option>
                                        <option value="peserta" {{ old('role', $user->role) == 'peserta' ? 'selected' : '' }}>Peserta</option>
                                    </select>
                                    @error('role')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Status <span class="text-red-600">*</span></label>
                                    <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('status') border-red-500 @enderror" required>
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-slate-700">Password Baru</label>
                                <input type="password" name="password" placeholder="Biarkan kosong jika tidak diubah" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('password') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-slate-500">Kosongkan jika tidak ingin mengubah password</p>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Data Pribadi</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NIK</label>
                                    <input type="text" name="nik" maxlength="16" pattern="[0-9]{16}" placeholder="16 digit NIK" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('nik') border-red-500 @enderror" value="{{ old('nik', $user->nik) }}">
                                    @error('nik')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                                    <input type="text" name="name" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Gelar</label>
                                    <input type="text" name="gelar" placeholder="S.Pd, M.Pd" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('gelar') border-red-500 @enderror" value="{{ old('gelar', $user->gelar) }}">
                                    @error('gelar')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('jenis_kelamin') border-red-500 @enderror">
                                        <option value="">Pilih</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">No HP</label>
                                    <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('no_hp') border-red-500 @enderror" value="{{ old('no_hp', $user->no_hp) }}">
                                    @error('no_hp')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Email Belajar.id</label>
                                    <input type="email" name="email_belajar_id" placeholder="nama@belajar.id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('email_belajar_id') border-red-500 @enderror" value="{{ old('email_belajar_id', $user->email_belajar_id) }}">
                                    @error('email_belajar_id')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Data Kepegawaian</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                                    <input type="text" name="jabatan" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('jabatan') border-red-500 @enderror" value="{{ old('jabatan', $user->jabatan) }}">
                                    @error('jabatan')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NIP/NIPY</label>
                                    <input type="text" name="nip_nipy" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('nip_nipy') border-red-500 @enderror" value="{{ old('nip_nipy', $user->nip_nipy) }}">
                                    @error('nip_nipy')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Pangkat</label>
                                    <input type="text" name="pangkat" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('pangkat') border-red-500 @enderror" value="{{ old('pangkat', $user->pangkat) }}">
                                    @error('pangkat')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Golongan</label>
                                    <input type="text" name="golongan" placeholder="III/c" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('golongan') border-red-500 @enderror" value="{{ old('golongan', $user->golongan) }}">
                                    @error('golongan')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Data Instansi/Sekolah</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NPSN</label>
                                    <input type="text" name="npsn" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('npsn') border-red-500 @enderror" value="{{ old('npsn', $user->npsn) }}">
                                    @error('npsn')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Instansi/Nama Sekolah</label>
                                    <input type="text" name="instansi" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('instansi') border-red-500 @enderror" value="{{ old('instansi', $user->instansi) }}">
                                    @error('instansi')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">KCD</label>
                                    <input type="text" name="kcd" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('kcd') border-red-500 @enderror" value="{{ old('kcd', $user->kcd) }}">
                                    @error('kcd')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-slate-700">Alamat Sekolah</label>
                                <textarea name="alamat_sekolah" rows="2" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('alamat_sekolah') border-red-500 @enderror">{{ old('alamat_sekolah', $user->alamat_sekolah) }}</textarea>
                                @error('alamat_sekolah')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Alamat Domisili</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Provinsi</label>
                                    <input type="text" name="provinsi_peserta" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('provinsi_peserta') border-red-500 @enderror" value="{{ old('provinsi_peserta', $user->provinsi_peserta) }}">
                                    @error('provinsi_peserta')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Kabupaten/Kota</label>
                                    <input type="text" name="kabupaten_kota" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('kabupaten_kota') border-red-500 @enderror" value="{{ old('kabupaten_kota', $user->kabupaten_kota) }}">
                                    @error('kabupaten_kota')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-slate-700">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" rows="2" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('alamat_lengkap') border-red-500 @enderror">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
                                @error('alamat_lengkap')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Riwayat Pendidikan</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Pendidikan Terakhir</label>
                                    <select name="pendidikan_terakhir" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('pendidikan_terakhir') border-red-500 @enderror">
                                        <option value="">Pilih</option>
                                        <option value="SMA/SMK" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                        <option value="D3" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="S1" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'S3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jurusan</label>
                                    <input type="text" name="jurusan" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('jurusan') border-red-500 @enderror" value="{{ old('jurusan', $user->jurusan) }}">
                                    @error('jurusan')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <h3 class="text-sm font-semibold text-slate-900">Upload Dokumen</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Foto 3x4</label>
                                    @if($user->foto_3x4)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($user->foto_3x4) }}" alt="Foto" class="h-20 w-16 rounded-lg object-cover shadow-sm ring-1 ring-slate-200">
                                        </div>
                                    @endif
                                    <input type="file" name="foto_3x4" accept="image/*" class="mt-1 w-full rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm @error('foto_3x4') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-slate-500">Max 2MB</p>
                                    @error('foto_3x4')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Surat Tugas</label>
                                    @if($user->surat_tugas)
                                        <div class="mb-2 flex items-center gap-2 text-sm">
                                            <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <a href="{{ Storage::url($user->surat_tugas) }}" target="_blank" class="text-indigo-600 hover:text-indigo-700">Lihat file</a>
                                        </div>
                                    @endif
                                    <input type="file" name="surat_tugas" accept=".pdf,.jpg,.jpeg,.png" class="mt-1 w-full rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm @error('surat_tugas') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-slate-500">PDF/Gambar, Max 2MB</p>
                                    @error('surat_tugas')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Tanda Tangan Digital</label>
                                    @if($user->tanda_tangan)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($user->tanda_tangan) }}" alt="Tanda Tangan" class="h-12 w-24 rounded-lg object-contain bg-slate-50 shadow-sm ring-1 ring-slate-200">
                                        </div>
                                    @endif
                                    <input type="file" name="tanda_tangan" accept="image/*" class="mt-1 w-full rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm @error('tanda_tangan') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-slate-500">PNG, Max 1MB</p>
                                    @error('tanda_tangan')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
                        <button type="button" @click="open = false" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white">Batal</button>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Update Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

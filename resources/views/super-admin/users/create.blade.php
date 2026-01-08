@extends('layouts.dashboard')

@section('title', 'Tambah Pengguna')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Tambah Pengguna Baru</h1>
        <a href="{{ route('super-admin.users') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('super-admin.users.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Data Akun -->
                <h5 class="text-primary border-bottom pb-2 mb-3">
                    <i class="bi bi-person-circle me-2"></i>Data Akun
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="fasilitator" {{ old('role') == 'fasilitator' ? 'selected' : '' }}>Fasilitator</option>
                            <option value="peserta" {{ old('role') == 'peserta' ? 'selected' : '' }}>Peserta</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Pribadi -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-person me-2"></i>Data Pribadi
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" maxlength="16" pattern="[0-9]{16}" placeholder="16 digit NIK">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gelar</label>
                        <input type="text" name="gelar" class="form-control @error('gelar') is-invalid @enderror" value="{{ old('gelar') }}" placeholder="S.Pd, M.Pd">
                        @error('gelar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email Belajar.id</label>
                        <input type="email" name="email_belajar_id" class="form-control @error('email_belajar_id') is-invalid @enderror" value="{{ old('email_belajar_id') }}" placeholder="nama@belajar.id">
                        @error('email_belajar_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Kepegawaian -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-briefcase me-2"></i>Data Kepegawaian
                </h5>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}">
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NIP/NIPY</label>
                        <input type="text" name="nip_nipy" class="form-control @error('nip_nipy') is-invalid @enderror" value="{{ old('nip_nipy') }}">
                        @error('nip_nipy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pangkat</label>
                        <input type="text" name="pangkat" class="form-control @error('pangkat') is-invalid @enderror" value="{{ old('pangkat') }}">
                        @error('pangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Golongan</label>
                        <input type="text" name="golongan" class="form-control @error('golongan') is-invalid @enderror" value="{{ old('golongan') }}" placeholder="III/c">
                        @error('golongan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Instansi -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-building me-2"></i>Data Instansi/Sekolah
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">NPSN</label>
                        <input type="text" name="npsn" class="form-control @error('npsn') is-invalid @enderror" value="{{ old('npsn') }}">
                        @error('npsn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Instansi/Nama Sekolah</label>
                        <input type="text" name="instansi" class="form-control @error('instansi') is-invalid @enderror" value="{{ old('instansi') }}">
                        @error('instansi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KCD</label>
                        <input type="text" name="kcd" class="form-control @error('kcd') is-invalid @enderror" value="{{ old('kcd') }}">
                        @error('kcd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Sekolah</label>
                    <textarea name="alamat_sekolah" class="form-control @error('alamat_sekolah') is-invalid @enderror" rows="2">{{ old('alamat_sekolah') }}</textarea>
                    @error('alamat_sekolah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat Domisili -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-geo-alt me-2"></i>Alamat Domisili
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi_peserta" class="form-control @error('provinsi_peserta') is-invalid @enderror" value="{{ old('provinsi_peserta') }}">
                        @error('provinsi_peserta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten_kota" class="form-control @error('kabupaten_kota') is-invalid @enderror" value="{{ old('kabupaten_kota') }}">
                        @error('kabupaten_kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" rows="2">{{ old('alamat_lengkap') }}</textarea>
                    @error('alamat_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pendidikan -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-mortarboard me-2"></i>Riwayat Pendidikan
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" class="form-select @error('pendidikan_terakhir') is-invalid @enderror">
                            <option value="">Pilih</option>
                            <option value="SMA/SMK" {{ old('pendidikan_terakhir') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('pendidikan_terakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" value="{{ old('jurusan') }}">
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i>Upload Dokumen (Opsional)
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Foto 3x4</label>
                        <input type="file" name="foto_3x4" class="form-control @error('foto_3x4') is-invalid @enderror" accept="image/*">
                        @error('foto_3x4')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max: 2MB</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Surat Tugas</label>
                        <input type="file" name="surat_tugas" class="form-control @error('surat_tugas') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @error('surat_tugas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">PDF/Image, Max: 2MB</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanda Tangan Digital</label>
                        <input type="file" name="tanda_tangan" class="form-control @error('tanda_tangan') is-invalid @enderror" accept="image/*">
                        @error('tanda_tangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">PNG, Max: 1MB</small>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('super-admin.users') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

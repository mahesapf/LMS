@extends('layouts.dashboard')

@section('title', 'Biodata Peserta')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('peserta.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('peserta.profile') }}">Profil</a>
    <a class="nav-link active" href="{{ route('peserta.biodata') }}">Biodata</a>
    <a class="nav-link" href="{{ route('peserta.classes') }}">Kelas & Nilai Saya</a>
    <a class="nav-link" href="{{ route('peserta.documents') }}">Dokumen</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Biodata Peserta</h1>
        <p class="text-muted">Lengkapi biodata Anda untuk keperluan administrasi</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('peserta.biodata.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Data Pribadi -->
                <h5 class="text-primary border-bottom pb-2 mb-3">
                    <i class="bi bi-person-circle me-2"></i>Data Pribadi
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                               value="{{ old('nik', $user->nik) }}" maxlength="16" pattern="[0-9]{16}"
                               placeholder="16 digit NIK">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Nomor Induk Kependudukan 16 digit</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Gelar</label>
                        <input type="text" name="gelar" class="form-control @error('gelar') is-invalid @enderror"
                               value="{{ old('gelar', $user->gelar) }}" placeholder="Contoh: S.Pd, M.Pd">
                        @error('gelar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                               value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx">
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kontak -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-envelope me-2"></i>Kontak
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Belajar.id</label>
                        <input type="email" name="email_belajar_id" class="form-control @error('email_belajar_id') is-invalid @enderror"
                               value="{{ old('email_belajar_id', $user->email_belajar_id) }}"
                               placeholder="nama@belajar.id">
                        @error('email_belajar_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kepegawaian -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-briefcase me-2"></i>Data Kepegawaian
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                               value="{{ old('jabatan', $user->jabatan) }}"
                               placeholder="Contoh: Guru Matematika">
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NIP/NIPY</label>
                        <input type="text" name="nip_nipy" class="form-control @error('nip_nipy') is-invalid @enderror"
                               value="{{ old('nip_nipy', $user->nip_nipy) }}">
                        @error('nip_nipy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Nomor Induk Pegawai/Yayasan</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NPSN</label>
                        <input type="text" name="npsn" class="form-control @error('npsn') is-invalid @enderror"
                               value="{{ old('npsn', $user->npsn) }}">
                        @error('npsn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Nomor Pokok Sekolah Nasional</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Pangkat</label>
                        <input type="text" name="pangkat" class="form-control @error('pangkat') is-invalid @enderror"
                               value="{{ old('pangkat', $user->pangkat) }}"
                               placeholder="Contoh: Penata">
                        @error('pangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Golongan</label>
                        <input type="text" name="golongan" class="form-control @error('golongan') is-invalid @enderror"
                               value="{{ old('golongan', $user->golongan) }}"
                               placeholder="Contoh: III/c">
                        @error('golongan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KCD</label>
                        <input type="text" name="kcd" class="form-control @error('kcd') is-invalid @enderror"
                               value="{{ old('kcd', $user->kcd) }}"
                               placeholder="Kantor Cabang Dinas">
                        @error('kcd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Instansi -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-building me-2"></i>Data Instansi/Sekolah
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Instansi/Nama Sekolah</label>
                        <input type="text" name="instansi" class="form-control @error('instansi') is-invalid @enderror"
                               value="{{ old('instansi', $user->instansi) }}">
                        @error('instansi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" class="form-control @error('alamat_sekolah') is-invalid @enderror"
                                  rows="2">{{ old('alamat_sekolah', $user->alamat_sekolah) }}</textarea>
                        @error('alamat_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Alamat Peserta -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-geo-alt me-2"></i>Alamat Domisili
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Provinsi</label>
                        <select name="provinsi_peserta" id="provinsi_peserta" class="form-select @error('provinsi_peserta') is-invalid @enderror"
                                onchange="updateCities(this, document.getElementById('kabupaten_kota'), document.getElementById('kecamatan'))">
                            <option value="">Pilih Provinsi</option>
                            <option value="Jawa Barat" {{ old('provinsi_peserta', $user->provinsi_peserta) == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                            <option value="Bengkulu" {{ old('provinsi_peserta', $user->provinsi_peserta) == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                            <option value="Lampung" {{ old('provinsi_peserta', $user->provinsi_peserta) == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                        </select>
                        @error('provinsi_peserta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kabupaten/Kota</label>
                        <select name="kabupaten_kota" id="kabupaten_kota" class="form-select @error('kabupaten_kota') is-invalid @enderror"
                                onchange="updateDistricts(document.getElementById('provinsi_peserta'), this, document.getElementById('kecamatan'))">
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-select @error('kecamatan') is-invalid @enderror">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <script>
                // Initialize dropdowns on page load
                document.addEventListener('DOMContentLoaded', function() {
                    const provinceSelect = document.getElementById('provinsi_peserta');
                    const citySelect = document.getElementById('kabupaten_kota');
                    const districtSelect = document.getElementById('kecamatan');

                    const savedProvince = "{{ old('provinsi_peserta', $user->provinsi_peserta) }}";
                    const savedCity = "{{ old('kabupaten_kota', $user->kabupaten_kota) }}";
                    const savedDistrict = "{{ old('kecamatan', $user->kecamatan) }}";

                    if (savedProvince) {
                        updateCities(provinceSelect, citySelect, districtSelect);
                        if (savedCity) {
                            setTimeout(() => {
                                citySelect.value = savedCity;
                                updateDistricts(provinceSelect, citySelect, districtSelect);
                                if (savedDistrict) {
                                    setTimeout(() => {
                                        districtSelect.value = savedDistrict;
                                    }, 100);
                                }
                            }, 100);
                        }
                    }
                });
                </script>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror"
                              rows="3">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
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
                            <option value="SMA/SMK" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('pendidikan_terakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
                               value="{{ old('jurusan', $user->jurusan) }}"
                               placeholder="Contoh: Pendidikan Matematika">
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i>Upload Dokumen
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Foto 3x4</label>
                        @if($user->foto_3x4)
                            <div class="mb-2">
                                <img src="{{ Storage::url($user->foto_3x4) }}" alt="Foto" class="img-thumbnail" style="max-width: 150px;">
                                <small class="d-block text-success"><i class="bi bi-check-circle"></i> Foto sudah diupload</small>
                            </div>
                        @endif
                        <input type="file" name="foto_3x4" class="form-control @error('foto_3x4') is-invalid @enderror" accept="image/*">
                        @error('foto_3x4')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Surat Tugas</label>
                        @if($user->surat_tugas)
                            <div class="mb-2">
                                <a href="{{ Storage::url($user->surat_tugas) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-pdf"></i> Lihat Surat Tugas
                                </a>
                            </div>
                        @endif
                        <input type="file" name="surat_tugas" class="form-control @error('surat_tugas') is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png">
                        @error('surat_tugas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanda Tangan Digital</label>
                        @if($user->tanda_tangan)
                            <div class="mb-2">
                                <img src="{{ Storage::url($user->tanda_tangan) }}" alt="Tanda Tangan" class="img-thumbnail" style="max-width: 150px;">
                                <small class="d-block text-success"><i class="bi bi-check-circle"></i> Tanda tangan sudah diupload</small>
                            </div>
                        @endif
                        <input type="file" name="tanda_tangan" class="form-control @error('tanda_tangan') is-invalid @enderror" accept="image/*">
                        @error('tanda_tangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: PNG (Max: 1MB, background transparan)</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Simpan Biodata
                    </button>
                    <a href="{{ route('peserta.dashboard') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/indonesia-location.js') }}"></script>
@endsection

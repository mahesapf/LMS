@extends('layouts.dashboard')

@section('title', 'Tambah Peserta')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link active" href="{{ route('admin.participants') }}">Manajemen Peserta</a>
    <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('admin.classes') }}">Kelas</a>
    <a class="nav-link" href="{{ route('admin.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tambah Peserta Baru</h1>
        <a href="{{ route('admin.participants') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.participants.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <!-- Biodata Dasar -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Biodata Dasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap (dengan gelar) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email_belajar" class="form-label">Email belajar.id</label>
                                <input type="email" class="form-control @error('email_belajar') is-invalid @enderror"
                                       id="email_belajar" name="email_belajar" value="{{ old('email_belajar') }}">
                                @error('email_belajar')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Nomor HP (WA) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                       id="nik" name="nik" value="{{ old('nik') }}" maxlength="16">
                                @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">Nomor Induk Pegawai (NIP)</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                       id="nip" name="nip" value="{{ old('nip') }}">
                                @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="npsn" class="form-label">NPSN</label>
                                <input type="text" class="form-control @error('npsn') is-invalid @enderror"
                                       id="npsn" name="npsn" value="{{ old('npsn') }}">
                                @error('npsn')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                       id="birth_place" name="birth_place" value="{{ old('birth_place') }}">
                                @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                       id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address" name="address" rows="2">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Kepegawaian -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Status Kepegawaian</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="pns_status" class="form-label">Status PNS</label>
                                <select class="form-select @error('pns_status') is-invalid @enderror"
                                        id="pns_status" name="pns_status" onchange="togglePNSFields()">
                                    <option value="">Pilih Status</option>
                                    <option value="PNS" {{ old('pns_status') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="Non PNS" {{ old('pns_status') == 'Non PNS' ? 'selected' : '' }}>Non PNS</option>
                                </select>
                                @error('pns_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3" id="rank_field" style="display: none;">
                                <label for="rank" class="form-label">Pangkat</label>
                                <input type="text" class="form-control @error('rank') is-invalid @enderror"
                                       id="rank" name="rank" value="{{ old('rank') }}">
                                @error('rank')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3" id="group_field" style="display: none;">
                                <label for="group" class="form-label">Golongan</label>
                                <input type="text" class="form-control @error('group') is-invalid @enderror"
                                       id="group" name="group" value="{{ old('group') }}">
                                @error('group')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan & Pekerjaan -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Pendidikan & Pekerjaan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="last_education" class="form-label">Pendidikan Terakhir</label>
                                <input type="text" class="form-control @error('last_education') is-invalid @enderror"
                                       id="last_education" name="last_education" value="{{ old('last_education') }}"
                                       placeholder="S1, S2, S3, dll">
                                @error('last_education')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="major" class="form-label">Jurusan</label>
                                <input type="text" class="form-control @error('major') is-invalid @enderror"
                                       id="major" name="major" value="{{ old('major') }}">
                                @error('major')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="institution" class="form-label">Instansi/Sekolah/Lembaga</label>
                                <input type="text" class="form-control @error('institution') is-invalid @enderror"
                                       id="institution" name="institution" value="{{ old('institution') }}">
                                @error('institution')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="position_type" class="form-label">Jabatan</label>
                                <select class="form-select @error('position_type') is-invalid @enderror"
                                        id="position_type" name="position_type" onchange="togglePositionFields()">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Guru" {{ old('position_type') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="Kepala Sekolah" {{ old('position_type') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                    <option value="Lainnya" {{ old('position_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('position_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3" id="position_field">
                                <label for="position" class="form-label">Detail Jabatan</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror"
                                       id="position" name="position" value="{{ old('position') }}">
                                @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Upload Files -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Upload Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                   id="photo" name="photo" accept="image/*">
                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG. Max 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label for="digital_signature" class="form-label">Tanda Tangan Digital</label>
                            <input type="file" class="form-control @error('digital_signature') is-invalid @enderror"
                                   id="digital_signature" name="digital_signature" accept="image/*">
                            @error('digital_signature')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG. Max 1MB</small>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Password</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save"></i> Simpan Peserta
                    </button>
                    <a href="{{ route('admin.participants') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function togglePNSFields() {
    const pnsStatus = document.getElementById('pns_status').value;
    const rankField = document.getElementById('rank_field');
    const groupField = document.getElementById('group_field');

    if (pnsStatus === 'PNS') {
        rankField.style.display = 'block';
        groupField.style.display = 'block';
    } else {
        rankField.style.display = 'none';
        groupField.style.display = 'none';
    }
}

function togglePositionFields() {
    const positionType = document.getElementById('position_type').value;
    const positionField = document.getElementById('position_field');

    if (positionType === 'Guru' || positionType === 'Kepala Sekolah') {
        positionField.style.display = 'block';
    } else {
        positionField.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePNSFields();
    togglePositionFields();
});
</script>
@endpush
@endsection

@extends('layouts.dashboard')

@section('title', 'Edit Biodata')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('fasilitator.dashboard') }}">Dashboard</a>
    <a class="nav-link active" href="{{ route('fasilitator.profile') }}">Edit Biodata</a>
    <a class="nav-link" href="{{ route('fasilitator.classes') }}">Input Nilai</a>
    <a class="nav-link" href="{{ route('fasilitator.documents') }}">Upload Dokumen</a>
    <a class="nav-link" href="{{ route('fasilitator.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Edit Biodata Fasilitator</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('fasilitator.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h6 class="text-primary mb-3 border-bottom pb-2">Biodata Fasilitator</h6>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah</small>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap (dengan gelar) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}"
                                   placeholder="Contoh: Dr. Ahmad Budiman, S.Pd., M.Pd." required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nip" class="form-label">Nomor Induk Pegawai (NIP)</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                   id="nip" name="nip" value="{{ old('nip', $user->nip) }}"
                                   placeholder="NIP">
                            @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                   id="nik" name="nik" value="{{ old('nik', $user->nik) }}"
                                   placeholder="NIK 16 digit" maxlength="16">
                            @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                       id="birth_place" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}"
                                       placeholder="Kota/Kabupaten">
                                @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                       id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rank" class="form-label">Pangkat</label>
                                <input type="text" class="form-control @error('rank') is-invalid @enderror"
                                       id="rank" name="rank" value="{{ old('rank', $user->rank) }}"
                                       placeholder="Contoh: Penata Muda, Pembina">
                                @error('rank')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="group" class="form-label">Golongan</label>
                                <input type="text" class="form-control @error('group') is-invalid @enderror"
                                       id="group" name="group" value="{{ old('group', $user->group) }}"
                                       placeholder="Contoh: III/a, IV/b">
                                @error('group')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="last_education" class="form-label">Pendidikan Terakhir</label>
                            <input type="text" class="form-control @error('last_education') is-invalid @enderror"
                                   id="last_education" name="last_education" value="{{ old('last_education', $user->last_education) }}"
                                   placeholder="Contoh: S1, S2, S3">
                            @error('last_education')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="major" class="form-label">Jurusan</label>
                            <input type="text" class="form-control @error('major') is-invalid @enderror"
                                   id="major" name="major" value="{{ old('major', $user->major) }}"
                                   placeholder="Contoh: Pendidikan Matematika, Teknik Informatika">
                            @error('major')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="institution" class="form-label">Instansi/Sekolah/Lembaga</label>
                            <input type="text" class="form-control @error('institution') is-invalid @enderror"
                                   id="institution" name="institution" value="{{ old('institution', $user->institution) }}"
                                   placeholder="Nama Instansi/Sekolah/Lembaga">
                            @error('institution')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Jabatan</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                                   id="position" name="position" value="{{ old('position', $user->position) }}"
                                   placeholder="Contoh: Dosen, Guru, Widyaiswara">
                            @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor HP (WA) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                   placeholder="08xxxxxxxxxx" required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email_belajar" class="form-label">Email belajar.id</label>
                            <input type="email" class="form-control @error('email_belajar') is-invalid @enderror"
                                   id="email_belajar" name="email_belajar" value="{{ old('email_belajar', $user->email_belajar) }}"
                                   placeholder="nama@belajar.id">
                            @error('email_belajar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto</label>
                            @if($user->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                   id="photo" name="photo" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="digital_signature" class="form-label">Tanda Tangan Digital</label>
                            @if($user->digital_signature)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->digital_signature) }}" alt="Tanda Tangan" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('digital_signature') is-invalid @enderror"
                                   id="digital_signature" name="digital_signature" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max: 1MB</small>
                            @error('digital_signature')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Role:</dt>
                        <dd class="col-sm-8"><span class="badge bg-info">Fasilitator</span></dd>

                        <dt class="col-sm-4">Status:</dt>
                        <dd class="col-sm-8">
                            @if($user->status == 'active')
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Bergabung:</dt>
                        <dd class="col-sm-8">{{ $user->created_at->format('d M Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Import Pengguna')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
    <a class="nav-link active" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
    <a class="nav-link" href="{{ route('super-admin.programs') }}">Program</a>
    <a class="nav-link" href="{{ route('super-admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('super-admin.classes.index') }}">Kelas</a>
    <a class="nav-link" href="{{ route('super-admin.payments.index') }}">Validasi Pembayaran</a>
    <a class="nav-link" href="{{ route('super-admin.registrations.index') }}">Kelola Pendaftaran</a>
    <a class="nav-link" href="{{ route('super-admin.admin-mappings') }}">Pemetaan Admin</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Import Pengguna dari CSV</h1>
        <a href="{{ route('super-admin.users') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upload File CSV</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('super-admin.users.import.process') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="fasilitator">Fasilitator</option>
                                <option value="peserta">Peserta</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">File CSV <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".csv" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">File harus berformat CSV (Comma Separated Values)</div>
                        </div>

                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Format File CSV</h5>
                </div>
                <div class="card-body">
                    <p>File CSV harus memiliki format berikut (sesuai biodata lengkap):</p>
                    
                    <div class="alert alert-info">
                        <strong>Header (baris pertama):</strong><br>
                        <small style="font-size: 0.85em;">
                        <code>email,nama,gelar,npsn,nip,nik,tempat_lahir,tanggal_lahir,jenis_kelamin,pns_status,pangkat,golongan,pendidikan_terakhir,jurusan,instansi,jabatan,nomor_wa,email_belajar</code>
                        </small>
                    </div>

                    <h6>Keterangan Kolom:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="small">
                                <li><strong>email</strong>*: Email unik</li>
                                <li><strong>nama</strong>*: Nama lengkap</li>
                                <li><strong>gelar</strong>: Gelar akademik</li>
                                <li><strong>npsn</strong>: NPSN</li>
                                <li><strong>nip</strong>: Nomor Induk Pegawai</li>
                                <li><strong>nik</strong>: Nomor Induk Kependudukan</li>
                                <li><strong>tempat_lahir</strong>: Tempat lahir</li>
                                <li><strong>tanggal_lahir</strong>: Format: YYYY-MM-DD</li>
                                <li><strong>jenis_kelamin</strong>: Laki-laki / Perempuan</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="small">
                                <li><strong>pns_status</strong>: PNS / Non PNS</li>
                                <li><strong>pangkat</strong>: Jika PNS</li>
                                <li><strong>golongan</strong>: Jika PNS</li>
                                <li><strong>pendidikan_terakhir</strong>: S1/S2/S3</li>
                                <li><strong>jurusan</strong>: Jurusan pendidikan</li>
                                <li><strong>instansi</strong>: Sekolah/Lembaga</li>
                                <li><strong>jabatan</strong>: Guru/Kepala Sekolah</li>
                                <li><strong>nomor_wa</strong>*: Nomor WhatsApp</li>
                                <li><strong>email_belajar</strong>: Email belajar.id</li>
                            </ul>
                        </div>
                    </div>
                    <small class="text-muted">* = Wajib diisi</small>

                    <div class="alert alert-warning mt-3">
                        <strong>Catatan:</strong>
                        <ul class="mb-0">
                            <li>Password default: <code>password123</code></li>
                            <li>Semua user akan berstatus <strong>aktif</strong></li>
                            <li>Email harus unik, jika sudah ada akan diskip</li>
                            <li>Format tanggal: <code>YYYY-MM-DD</code> (contoh: 2000-01-15)</li>
                            <li>Foto dan tanda tangan digital diupload manual setelah import</li>
                        </ul>
                    </div>

                    <h6>Download Template:</h6>
                    <a href="#" class="btn btn-sm btn-outline-primary" onclick="downloadTemplate(); return false;">
                        <i class="bi bi-download"></i> Download Template CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadTemplate() {
    const csv = 'email,nama,gelar,npsn,nip,nik,tempat_lahir,tanggal_lahir,jenis_kelamin,pns_status,pangkat,golongan,pendidikan_terakhir,jurusan,instansi,jabatan,nomor_wa,email_belajar\n' +
                'john.doe@example.com,John Doe,S.Pd.,12345678,198001011234567890,3201011234567890,Jakarta,1980-01-01,Laki-laki,PNS,Penata,III/c,S1,Pendidikan Matematika,SMA Negeri 1,Guru,081234567890,john.doe@belajar.id\n' +
                'jane.smith@example.com,Jane Smith,M.Pd.,12345679,198502021234567891,3201021234567891,Bandung,1985-02-02,Perempuan,PNS,Penata Muda Tingkat I,III/b,S2,Pendidikan Bahasa Indonesia,SMP Negeri 2,Kepala Sekolah,081234567891,jane.smith@belajar.id';
    
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'template_import_users_lengkap.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>
@endsection

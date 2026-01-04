@extends('layouts.dashboard')

@section('title', 'Import Pengguna')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
    <a class="nav-link active" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
    <a class="nav-link" href="{{ route('super-admin.programs') }}">Program</a>
    <a class="nav-link" href="{{ route('super-admin.activities') }}">Kegiatan</a>
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
                    <p>File CSV harus memiliki format berikut:</p>
                    
                    <div class="alert alert-info">
                        <strong>Header (baris pertama):</strong><br>
                        <code>nama,gelar,email,nomor_wa</code>
                    </div>

                    <div class="alert alert-secondary">
                        <strong>Contoh data:</strong><br>
                        <code>John Doe,S.Pd.,john@example.com,081234567890</code><br>
                        <code>Jane Smith,M.Pd.,jane@example.com,081234567891</code>
                    </div>

                    <h6>Keterangan:</h6>
                    <ul>
                        <li><strong>nama</strong>: Nama lengkap (wajib)</li>
                        <li><strong>gelar</strong>: Gelar akademik (opsional)</li>
                        <li><strong>email</strong>: Email unik (wajib)</li>
                        <li><strong>nomor_wa</strong>: Nomor WhatsApp (wajib)</li>
                    </ul>

                    <div class="alert alert-warning">
                        <strong>Catatan:</strong>
                        <ul class="mb-0">
                            <li>Password default: <code>password123</code></li>
                            <li>Semua user akan berstatus <strong>aktif</strong></li>
                            <li>Email harus unik dan belum terdaftar</li>
                        </ul>
                    </div>

                    <h6>Download Template:</h6>
                    <a href="#" class="btn btn-sm btn-outline-primary" onclick="downloadTemplate(); return false;">
                        Download Template CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadTemplate() {
    const csv = 'nama,gelar,email,nomor_wa\nJohn Doe,S.Pd.,john@example.com,081234567890\nJane Smith,M.Pd.,jane@example.com,081234567891';
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'template_import_users.csv';
    a.click();
}
</script>
@endsection

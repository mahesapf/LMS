@extends('layouts.dashboard')

@section('title', 'Import Pengguna')

@section('sidebar')
@include('super-admin.partials.sidebar')
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
                    <p>File CSV harus memiliki format sederhana berikut:</p>

                    <div class="alert alert-info">
                        <strong>Header (baris pertama):</strong><br>
                        <code>nama_lengkap,nik,email</code>
                    </div>

                    <h6>Keterangan Kolom:</h6>
                    <ul class="small">
                        <li><strong>nama_lengkap</strong>* (Wajib): Nama lengkap pengguna</li>
                        <li><strong>nik</strong> (Opsional): Nomor Induk Kependudukan - juga akan digunakan sebagai password login</li>
                        <li><strong>email</strong>* (Wajib): Email unik untuk login dan notifikasi</li>
                    </ul>

                    <div class="alert alert-warning mt-3">
                        <strong><i class="bi bi-info-circle"></i> Penting:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Kolom yang diberi tanda (*) wajib diisi</li>
                            <li><strong>Email</strong> digunakan sebagai <strong>username login</strong></li>
                            <li><strong>NIK</strong> digunakan sebagai <strong>password login</strong></li>
                            <li>Jika NIK kosong, password default adalah <code>password123</code></li>
                            <li>Email harus unik, jika sudah terdaftar maka data akan dilewati</li>
                            <li>Pastikan tidak ada baris kosong di file CSV</li>
                        </ul>
                    </div>

                    <h6 class="mt-3">Contoh Data:</h6>
                    <div class="bg-light p-3 rounded">
                        <pre class="mb-0" style="font-size: 0.85em;">nama_lengkap,nik,email
John Doe,3201234567890123,john.doe@example.com
Jane Smith,3301234567890123,jane.smith@example.com
Ahmad Yani,,ahmad.yani@example.com</pre>
                    </div>
                    <small class="text-muted">Note: Baris ketiga tidak memiliki NIK, sehingga password default <code>password123</code> akan digunakan.</small>

                    <div class="mt-3">
                        <a href="data:text/csv;charset=utf-8,nama_lengkap,nik,email%0AContoh Nama,3201234567890123,contoh@example.com" 
                           download="template_import_user.csv" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download"></i> Download Template CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

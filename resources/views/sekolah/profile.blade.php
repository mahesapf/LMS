@extends('layouts.sekolah')

@section('title', 'Profil Sekolah')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Profil Sekolah</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sekolah.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informasi Sekolah</h4>
                    <form method="POST" action="{{ route('sekolah.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Sekolah</label>
                            <input type="text" class="form-control" value="{{ $user->nama_sekolah }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>NPSN</label>
                            <input type="text" class="form-control" value="{{ $user->npsn }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Provinsi</label>
                            <input type="text" class="form-control" value="{{ $user->provinsi }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Kabupaten/Kota</label>
                            <input type="text" name="kabupaten" class="form-control @error('kabupaten') is-invalid @enderror" 
                                   value="{{ old('kabupaten', $user->kabupaten) }}" required>
                            @error('kabupaten')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Kepala Sekolah</label>
                            <input type="text" name="nama_kepala_sekolah" class="form-control @error('nama_kepala_sekolah') is-invalid @enderror" 
                                   value="{{ old('nama_kepala_sekolah', $user->nama_kepala_sekolah) }}" required>
                            @error('nama_kepala_sekolah')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email Belajar.id</label>
                            <input type="email" class="form-control" value="{{ $user->email_belajar_id }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>No WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" 
                                   value="{{ old('no_wa', $user->no_wa) }}" required>
                            @error('no_wa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Pendaftar</label>
                            <input type="text" name="pendaftar" class="form-control @error('pendaftar') is-invalid @enderror" 
                                   value="{{ old('pendaftar', $user->pendaftar) }}" required>
                            @error('pendaftar')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jabatan Pendaftar</label>
                            <input type="text" class="form-control" value="{{ $user->jabatan_pendaftar }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Daftar</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('d M Y H:i') }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Status Akun</h4>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-1">Status Approval</p>
                        @if($user->approval_status == 'approved')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($user->approval_status == 'pending')
                            <span class="badge badge-warning">Menunggu</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <p class="text-muted mb-1">Status Akun</p>
                        @if($user->status == 'active')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Tidak Aktif</span>
                        @endif
                    </div>

                    @if($user->approved_at)
                    <div class="mb-3">
                        <p class="text-muted mb-1">Disetujui Pada</p>
                        <p>{{ $user->approved_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif

                    @if($user->sk_pendaftar)
                    <div class="mb-3">
                        <p class="text-muted mb-1">SK Pendaftar</p>
                        <a href="{{ asset('storage/' . $user->sk_pendaftar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="mdi mdi-file-document"></i> Lihat SK
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

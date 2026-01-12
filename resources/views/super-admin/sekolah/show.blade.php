@extends('layouts.dashboard')

@section('title', 'Detail Sekolah')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="page-header">
        <h3 class="page-title">Detail Sekolah</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('super-admin.sekolah.index') }}">Manajemen Sekolah</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Informasi Sekolah</h4>
                        <div>
                            @if($sekolah->approval_status == 'pending')
                                <form action="{{ route('super-admin.sekolah.approve', $sekolah->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran sekolah ini?')">
                                        <i class="mdi mdi-check"></i> Setujui
                                    </button>
                                </form>
                                
                                <form action="{{ route('super-admin.sekolah.reject', $sekolah->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning"
                                            onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran sekolah ini?')">
                                        <i class="mdi mdi-close"></i> Tolak
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('super-admin.sekolah.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Status Approval</th>
                                    <td>
                                        @if($sekolah->approval_status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($sekolah->approval_status == 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Sekolah</th>
                                    <td>{{ $sekolah->nama_sekolah }}</td>
                                </tr>
                                <tr>
                                    <th>NPSN</th>
                                    <td>{{ $sekolah->npsn }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $sekolah->provinsi }}</td>
                                </tr>
                                <tr>
                                    <th>Kabupaten/Kota</th>
                                    <td>{{ $sekolah->kabupaten }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Kepala Sekolah</th>
                                    <td>{{ $sekolah->nama_kepala_sekolah }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Email Belajar.id</th>
                                    <td>{{ $sekolah->email_belajar_id }}</td>
                                </tr>
                                <tr>
                                    <th>No WhatsApp</th>
                                    <td>{{ $sekolah->no_wa }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pendaftar</th>
                                    <td>{{ $sekolah->pendaftar }}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan Pendaftar</th>
                                    <td>{{ $sekolah->jabatan_pendaftar }}</td>
                                </tr>
                                <tr>
                                    <th>SK Pendaftar</th>
                                    <td>
                                        @if($sekolah->sk_pendaftar)
                                            <a href="{{ route('super-admin.sekolah.download-sk', $sekolah->id) }}" 
                                               class="btn btn-sm btn-primary" target="_blank">
                                                <i class="mdi mdi-download"></i> Download SK
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Daftar</th>
                                    <td>{{ $sekolah->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @if($sekolah->approved_at)
                                <tr>
                                    <th>Tanggal Disetujui</th>
                                    <td>{{ $sekolah->approved_at->format('d M Y H:i') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Manajemen Sekolah')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="page-header">
        <h3 class="page-title">Manajemen Sekolah</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manajemen Sekolah</li>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Status -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Sekolah</h4>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('super-admin.sekolah.index', ['status' => 'all']) }}" 
                               class="btn btn-sm {{ request('status', 'all') == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Semua
                            </a>
                            <a href="{{ route('super-admin.sekolah.index', ['status' => 'pending']) }}" 
                               class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                                Pending
                            </a>
                            <a href="{{ route('super-admin.sekolah.index', ['status' => 'approved']) }}" 
                               class="btn btn-sm {{ request('status') == 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                                Disetujui
                            </a>
                            <a href="{{ route('super-admin.sekolah.index', ['status' => 'rejected']) }}" 
                               class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                                Ditolak
                            </a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Sekolah</th>
                                    <th>NPSN</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Email Belajar.id</th>
                                    <th>Pendaftar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sekolahs as $index => $sekolah)
                                    <tr>
                                        <td>{{ $sekolahs->firstItem() + $index }}</td>
                                        <td>{{ $sekolah->nama_sekolah }}</td>
                                        <td>{{ $sekolah->npsn }}</td>
                                        <td>{{ $sekolah->provinsi }}</td>
                                        <td>{{ $sekolah->kabupaten }}</td>
                                        <td>{{ $sekolah->email_belajar_id }}</td>
                                        <td>{{ $sekolah->pendaftar }}</td>
                                        <td>
                                            @if($sekolah->approval_status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($sekolah->approval_status == 'approved')
                                                <span class="badge badge-success">Disetujui</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('super-admin.sekolah.show', $sekolah->id) }}" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            
                                            @if($sekolah->approval_status == 'pending')
                                                <form action="{{ route('super-admin.sekolah.approve', $sekolah->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                            title="Setujui"
                                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran sekolah ini?')">
                                                        <i class="mdi mdi-check"></i>
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('super-admin.sekolah.reject', $sekolah->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-warning" 
                                                            title="Tolak"
                                                            onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran sekolah ini?')">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('super-admin.sekolah.destroy', $sekolah->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus akun sekolah ini?')">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data sekolah</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $sekolahs->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

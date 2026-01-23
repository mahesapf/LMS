@extends('layouts.dashboard')

@section('title', 'Upload Dokumen')

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Upload Dokumen</h1>
        <a href="{{ route('fasilitator.documents.upload') }}" class="btn btn-primary">
            <i class="bi bi-upload"></i> Upload Dokumen
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Nama File</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $document)
                        <tr>
                            <td>{{ $loop->iteration + ($documents->currentPage() - 1) * $documents->perPage() }}</td>
                            <td>
                                <strong>{{ $document->title }}</strong>
                                @if($document->description)
                                <br><small class="text-muted">{{ Str::limit($document->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($document->type == 'surat_tugas')
                                <span class="badge bg-primary">Surat Tugas</span>
                                @else
                                <span class="badge bg-secondary">Lainnya</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $document->file_name }}</small>
                            </td>
                            <td>{{ $document->uploaded_date ? \Carbon\Carbon::parse($document->uploaded_date)->format('d M Y H:i') : '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ asset('storage/' . $document->file_path) }}"
                                       class="btn btn-outline-primary"
                                       target="_blank"
                                       title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ asset('storage/' . $document->file_path) }}"
                                       class="btn btn-outline-success"
                                       download
                                       title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form action="{{ route('fasilitator.documents.delete', $document) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-outline-danger"
                                                title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada dokumen</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($documents->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $documents->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

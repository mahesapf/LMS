@extends('layouts.dashboard')

@section('title', 'Dokumen Saya')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('peserta.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('peserta.profile') }}">Profil</a>
    <a class="nav-link" href="{{ route('peserta.biodata') }}">Biodata</a>
    <a class="nav-link" href="{{ route('peserta.classes') }}">Kelas & Nilai Saya</a>
    <a class="nav-link active" href="{{ route('peserta.documents') }}">Dokumen</a>
</nav>
@endsection

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-2">Dokumen Saya</h1>
    <p class="text-gray-500 mb-6">Upload dokumen yang diminta sesuai tahap kegiatan</p>

    @if(session('success'))
    <div class="alert alert-success shadow-lg mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error shadow-lg mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @if($myClasses->count() > 0)
    @foreach($myClasses as $mapping)
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                {{ $mapping->class->name }}
            </h2>
            <p class="text-sm text-gray-500">{{ $mapping->class->activity->name ?? '-' }}</p>

            @php
                $stages = $mapping->class->stages ?? collect();
            @endphp

            @if($stages->count() > 0)
            <!-- Stages Accordion -->
            <div class="space-y-2 mt-4">
                @foreach($stages as $stage)
                <div class="collapse collapse-arrow bg-base-200 rounded-box">
                    <input type="checkbox" {{ $loop->first ? 'checked' : '' }}>
                    <div class="collapse-title font-semibold flex items-center gap-2">
                        <span>{{ $stage->name }}</span>
                        <span class="badge
                            @if($stage->status == 'ongoing') badge-success
                            @elseif($stage->status == 'completed') badge-ghost
                            @else badge-warning
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $stage->status)) }}
                        </span>
                        @php
                            $totalDocs = $stage->documentRequirements->count();
                            $uploadedDocs = $stage->documentRequirements->filter(function($req) {
                                return $req->documents->where('uploaded_by', Auth::id())->count() > 0;
                            })->count();
                        @endphp
                        <span class="badge badge-info">{{ $uploadedDocs }}/{{ $totalDocs }} dokumen</span>
                    </div>
                    <div class="collapse-content">
                        @if($stage->description)
                        <div class="alert alert-info mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $stage->description }}</span>
                        </div>
                        @endif

                        @if($stage->start_date || $stage->end_date)
                        <p class="text-sm text-gray-500 mb-4">
                            @if($stage->start_date)
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Mulai: {{ $stage->start_date->format('d M Y') }}
                            @endif
                            @if($stage->end_date)
                            | Selesai: {{ $stage->end_date->format('d M Y') }}
                            @endif
                        </p>
                        @endif

                        @if($stage->documentRequirements->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dokumen</th>
                                        <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stage->documentRequirements as $req)
                                        @php
                                            $uploaded = $req->documents->where('uploaded_by', Auth::id())->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="font-semibold">{{ $req->document_name }}</div>
                                                @if($req->is_required)
                                                <span class="badge badge-error badge-sm">Wajib</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-sm">
                                                    {{ $req->description ?? '-' }}
                                                    @if($req->document_type)
                                                    <div class="badge badge-info badge-sm mt-1">{{ strtoupper($req->document_type) }}</div>
                                                    @endif
                                                    <div class="text-gray-500 mt-1">Max: {{ number_format($req->max_file_size / 1024, 1) }} MB</div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($uploaded)
                                                <span class="badge badge-success gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    Sudah Upload
                                                </span>
                                                @else
                                                <span class="badge badge-warning gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                    Belum Upload
                                                </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($uploaded)
                                                <div class="text-sm">
                                                    {{ Str::limit(basename($uploaded->file_path), 25) }}
                                                    <div class="text-gray-500 text-xs">
                                                        {{ $uploaded->created_at->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                                @else
                                                <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($uploaded)
                                                <div class="flex flex-col gap-2">
                                                    <a href="{{ Storage::url($uploaded->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                        Lihat
                                                    </a>
                                                    <label for="modal-upload-{{ $req->id }}" class="btn btn-warning btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                                        Ganti
                                                    </label>
                                                    <form action="{{ route('peserta.documents.destroy', $uploaded) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-error btn-sm w-full" onclick="return confirm('Yakin ingin menghapus?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                                @else
                                                <label for="modal-upload-{{ $req->id }}" class="btn btn-primary btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                                    Upload
                                                </label>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Upload Modal -->
                                        <input type="checkbox" id="modal-upload-{{ $req->id }}" class="modal-toggle" />
                                        <div class="modal">
                                            <div class="modal-box relative max-w-lg">
                                                <label for="modal-upload-{{ $req->id }}" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                                                <h3 class="font-bold text-lg mb-4">Upload {{ $req->document_name }}</h3>

                                                <form action="{{ route('peserta.documents.upload') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="document_requirement_id" value="{{ $req->id }}">
                                                    <input type="hidden" name="class_id" value="{{ $mapping->class->id }}">

                                                    @if($req->description)
                                                    <div class="alert alert-info mb-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        <span>{{ $req->description }}</span>
                                                    </div>
                                                    @endif

                                                    <div class="form-control w-full mb-4">
                                                        <label class="label">
                                                            <span class="label-text">Pilih File <span class="text-error">*</span></span>
                                                        </label>
                                                        <input type="file" name="file" class="file-input file-input-bordered w-full" required
                                                               @if($req->document_type) accept=".{{ str_replace(',', ',.', $req->document_type) }}" @endif>
                                                        <label class="label">
                                                            <span class="label-text-alt">
                                                                @if($req->document_type)
                                                                Tipe: {{ strtoupper($req->document_type) }} |
                                                                @endif
                                                                Maks: {{ number_format($req->max_file_size / 1024, 1) }} MB
                                                            </span>
                                                        </label>
                                                    </div>

                                                    <div class="form-control w-full mb-4">
                                                        <label class="label">
                                                            <span class="label-text">Catatan (Opsional)</span>
                                                        </label>
                                                        <textarea name="notes" rows="3" class="textarea textarea-bordered" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                                                    </div>

                                                    @if($uploaded)
                                                    <div class="alert alert-warning mb-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                        <span>File yang sudah ada akan diganti dengan file baru.</span>
                                                    </div>
                                                    @endif

                                                    <div class="modal-action">
                                                        <label for="modal-upload-{{ $req->id }}" class="btn btn-ghost">Batal</label>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Belum ada dokumen requirement untuk tahap ini.</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Belum ada tahap yang dibuat untuk kelas ini.</span>
            </div>
            @endif
        </div>
    </div>
    @endforeach
    @else
    <div class="alert alert-info text-center">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-12 h-12 mx-auto mb-3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-semibold text-lg">Anda belum terdaftar di kelas manapun</p>
            <p class="text-sm mt-2">Silakan hubungi admin untuk mendaftarkan Anda ke kelas.</p>
        </div>
    </div>
    @endif
</div>
@endsection

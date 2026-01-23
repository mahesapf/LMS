@extends('layouts.dashboard')

@section('title', 'Tugas Peserta - ' . $class->name)

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">Tugas Peserta</h1>
            <p class="text-gray-500 mt-1">{{ $class->name }} - {{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('fasilitator.classes.detail', $class) }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Detail Kelas
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-lg mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="stats shadow border border-primary">
            <div class="stat">
                <div class="stat-title text-primary">Total Tugas</div>
                <div class="stat-value text-primary">{{ $requirements->count() }}</div>
            </div>
        </div>
        <div class="stats shadow border border-info">
            <div class="stat">
                <div class="stat-title text-info">Total Peserta</div>
                <div class="stat-value text-info">{{ $totalParticipants }}</div>
            </div>
        </div>
        <div class="stats shadow border border-success">
            <div class="stat">
                <div class="stat-title text-success">Total Submisi</div>
                <div class="stat-value text-success">{{ $requirements->sum('documents_count') }}</div>
            </div>
        </div>
        <div class="stats shadow border border-warning">
            <div class="stat">
                <div class="stat-title text-warning">Completion Rate</div>
                <div class="stat-value text-warning">
                    @php
                        $totalExpected = $requirements->count() * $totalParticipants;
                        $completionRate = $totalExpected > 0 ? round(($requirements->sum('documents_count') / $totalExpected) * 100, 1) : 0;
                    @endphp
                    {{ $completionRate }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Document Requirements List -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Daftar Tugas Per Tahap</h2>
                <label for="createRequirementModal" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Tugas Baru
                </label>
            </div>
            @if($requirements->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahap</th>
                                <th>Nama Tugas</th>
                                <th>Tipe Dokumen</th>
                                <th>Status</th>
                                <th>Submisi</th>
                                <th>Progress</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requirements as $index => $requirement)
                            @php
                                $submissionCount = $requirement->documents_count;
                                $progress = $totalParticipants > 0 ? round(($submissionCount / $totalParticipants) * 100) : 0;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge badge-secondary">{{ $requirement->stage->name ?? 'Umum' }}</span>
                                </td>
                                <td>
                                    <div class="font-semibold">{{ $requirement->document_name }}</div>
                                    @if($requirement->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($requirement->description, 50) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ strtoupper($requirement->document_type) }}</span>
                                </td>
                                <td>
                                    @if($requirement->is_required)
                                        <span class="badge badge-error">Wajib</span>
                                    @else
                                        <span class="badge badge-ghost">Opsional</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="font-bold text-primary">{{ $submissionCount }}</span> / {{ $totalParticipants }}
                                </td>
                                <td style="min-width: 150px;">
                                    <div class="flex items-center gap-2">
                                        <progress class="progress {{ $progress >= 100 ? 'progress-success' : ($progress >= 50 ? 'progress-info' : 'progress-warning') }} w-20" value="{{ $progress }}" max="100"></progress>
                                        <span class="text-sm">{{ $progress }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('fasilitator.classes.submissions', [$class, $requirement]) }}"
                                           class="btn btn-primary btn-sm" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('fasilitator.classes.document-requirements.delete', [$class, $requirement]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus tugas ini? Semua submisi peserta akan ikut terhapus!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-sm" title="Hapus Tugas">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Belum ada tugas yang dibuat untuk kelas ini. Klik tombol "Buat Tugas Baru" untuk membuat tugas pertama.</span>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Create Requirement (DaisyUI) -->
<input type="checkbox" id="createRequirementModal" class="modal-toggle" />
<div class="modal" x-data="{
    stage_id: '',
    documents: [{
        document_name: '',
        document_type: '',
        description: '',
        is_required: '1',
        max_file_size: 10
    }],
    addDocument() {
        this.documents.push({
            document_name: '',
            document_type: '',
            description: '',
            is_required: '1',
            max_file_size: 10
        });
    },
    removeDocument(index) {
        if (this.documents.length > 1) {
            this.documents.splice(index, 1);
        }
    }
}">
    <div class="modal-box w-11/12 max-w-4xl max-h-[90vh] overflow-y-auto">
        <form action="{{ route('fasilitator.classes.document-requirements.store', $class) }}" method="POST">
            @csrf
            <h3 class="font-bold text-lg mb-4">Buat Tugas Baru</h3>

            <!-- Pilih Tahap -->
            <div class="form-control w-full mb-6 pb-6 border-b border-gray-200">
                <label class="label">
                    <span class="label-text font-semibold">Pilih Tahap</span>
                </label>
                <select x-model="stage_id" name="stage_id" class="select select-bordered select-primary">
                    <option value="">-- Semua Tahap / Umum --</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>
                <label class="label">
                    <span class="label-text-alt">Jika tidak dipilih, tugas akan masuk kategori "Umum"</span>
                </label>
            </div>

            <!-- Dynamic Document Forms -->
            <div class="space-y-6">
                <template x-for="(doc, index) in documents" :key="index">
                    <div class="p-4 border-2 border-dashed border-gray-300 rounded-lg bg-base-200">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-semibold" x-text="'Dokumen ' + (index + 1)"></h4>
                            <button type="button"
                                    x-show="documents.length > 1"
                                    @click="removeDocument(index)"
                                    class="btn btn-error btn-sm btn-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <!-- Nama Dokumen -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Nama Dokumen <span class="text-error">*</span></span>
                                </label>
                                <input type="text"
                                       :name="'documents[' + index + '][document_name]'"
                                       x-model="doc.document_name"
                                       class="input input-bordered w-full"
                                       placeholder="Contoh: Upload Sertifikat Pelatihan"
                                       required>
                                <input type="hidden" :name="'documents[' + index + '][stage_id]'" x-model="stage_id">
                            </div>

                            <!-- Tipe Dokumen & Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Tipe Dokumen <span class="text-error">*</span></span>
                                    </label>
                                    <select :name="'documents[' + index + '][document_type]'"
                                            x-model="doc.document_type"
                                            class="select select-bordered"
                                            required>
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="pdf">PDF</option>
                                        <option value="doc">Word (DOC/DOCX)</option>
                                        <option value="ppt">PowerPoint</option>
                                        <option value="image">Gambar (JPG/PNG)</option>
                                        <option value="video">Video</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>

                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Status Tugas <span class="text-error">*</span></span>
                                    </label>
                                    <select :name="'documents[' + index + '][is_required]'"
                                            x-model="doc.is_required"
                                            class="select select-bordered"
                                            required>
                                        <option value="1">Wajib</option>
                                        <option value="0">Opsional</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Deskripsi/Instruksi</span>
                                </label>
                                <textarea :name="'documents[' + index + '][description]'"
                                          x-model="doc.description"
                                          rows="2"
                                          class="textarea textarea-bordered"
                                          placeholder="Jelaskan instruksi atau detail tugas..."></textarea>
                            </div>

                            <!-- Ukuran File -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Ukuran File Maksimal (MB)</span>
                                </label>
                                <input type="number"
                                       :name="'documents[' + index + '][max_file_size]'"
                                       x-model="doc.max_file_size"
                                       class="input input-bordered w-full"
                                       min="1" max="50" step="0.1">
                                <label class="label">
                                    <span class="label-text-alt">Default: 10 MB</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Add Document Button -->
                <button type="button"
                        @click="addDocument()"
                        class="btn btn-outline btn-primary w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Dokumen Lain untuk Tahap Ini
                </button>
            </div>

            <div class="modal-action mt-6">
                <label for="createRequirementModal" class="btn btn-ghost">Batal</label>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan <span x-text="documents.length"></span> Tugas
                </button>
            </div>
        </form>
    </div>
    <label class="modal-backdrop" for="createRequirementModal"></label>
</div>
@endsection

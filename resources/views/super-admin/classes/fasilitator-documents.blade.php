@extends('layouts.dashboard')

@section('title', 'Dokumen Fasilitator - ' . $class->name)

@section('sidebar')
    @include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Dokumen untuk Fasilitator</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $class->name }} · {{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('super-admin.classes.show', $class) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="border-l-4 border-emerald-600 bg-emerald-50 p-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="border-l-4 border-red-600 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="border-l-4 border-red-600 bg-red-50 p-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">Tambah Requirement Dokumen</h2>
            <p class="mt-1 text-sm text-slate-500">Dokumen ini akan muncul di detail kelas fasilitator untuk kelas ini.</p>
        </div>
        <div class="px-6 py-4">
            <form action="{{ route('super-admin.classes.fasilitatorDocuments.store', $class) }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                @csrf

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Tahap</label>
                    <select name="stage_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900">
                        <option value="">Umum (tanpa tahap)</option>
                        @foreach($stages as $stage)
                            <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama Dokumen</label>
                    <input type="text" name="document_name" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900" placeholder="Contoh: Laporan Kegiatan Tahap 1">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Tipe File (opsional)</label>
                    <select name="document_type" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900">
                        <option value="">Semua Tipe File</option>
                        <option value="pdf">PDF</option>
                        <option value="doc,docx">Word (DOC/DOCX)</option>
                        <option value="xls,xlsx">Excel (XLS/XLSX)</option>
                        <option value="ppt,pptx">PowerPoint (PPT/PPTX)</option>
                        <option value="jpg,jpeg,png">Gambar (JPG/PNG)</option>
                        <option value="pdf,doc,docx">PDF atau Word</option>
                        <option value="pdf,doc,docx,xls,xlsx">PDF, Word, atau Excel</option>
                        <option value="zip,rar">Arsip (ZIP/RAR)</option>
                        <option value="pdf,doc,docx,jpg,jpeg,png">Dokumen atau Gambar</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Ukuran Maks (KB)</label>
                    <input type="number" name="max_file_size" min="100" value="5120" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi (opsional)</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900" placeholder="Instruksi upload untuk fasilitator"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Template/Contoh Dokumen (opsional)</label>
                    <input type="file" name="template_file" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900">
                    <p class="mt-1 text-xs text-slate-500">File ini akan bisa didownload oleh fasilitator sebagai contoh/format.</p>
                </div>

                <div class="md:col-span-2 flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <input type="checkbox" name="is_required" value="1" checked class="rounded border-slate-300">
                        Wajib
                    </label>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0369a1]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">Daftar Requirement</h2>
        </div>

        <div class="p-6 space-y-6">
            <div class="rounded-lg border border-slate-200">
                <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-sm font-semibold text-slate-900">Umum (tanpa tahap)</p>
                </div>
                <div class="p-4">
                    @if($generalRequirements->isEmpty())
                        <p class="text-sm text-slate-500">Belum ada requirement.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">#</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">Nama</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">Tipe</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">Max</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">Wajib</th>
                                        <th class="px-3 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @foreach($generalRequirements as $req)
                                        <tr>
                                            <td class="px-3 py-2 text-sm text-slate-700">{{ $loop->iteration }}</td>
                                            <td class="px-3 py-2 text-sm">
                                                <div class="font-semibold text-slate-900">{{ $req->document_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $req->description ?? '-' }}</div>
                                                @if(!empty($req->template_file_path))
                                                    <div class="mt-1">
                                                        <a href="{{ Storage::url($req->template_file_path) }}" target="_blank" class="text-xs font-semibold text-indigo-700 hover:underline">
                                                            Download Template: {{ $req->template_file_name ?? 'template' }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-sm text-slate-700">{{ $req->document_type ?: 'Semua' }}</td>
                                            <td class="px-3 py-2 text-sm text-slate-700">{{ number_format($req->max_file_size / 1024, 1) }} MB</td>
                                            <td class="px-3 py-2 text-sm">
                                                @if($req->is_required)
                                                    <span class="inline-flex rounded-full bg-red-500 px-2.5 py-0.5 text-xs font-semibold text-white">Wajib</span>
                                                @else
                                                    <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Opsional</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-right">
                                                <form action="{{ route('super-admin.classes.fasilitatorDocuments.delete', [$class, $req]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus requirement ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center rounded-lg border border-rose-300 bg-white px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            @foreach($stages as $stage)
                <div class="rounded-lg border border-slate-200">
                    <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-sm font-semibold text-slate-900">{{ $stage->name }}</p>
                    </div>
                    <div class="p-4">
                        @if($stage->documentRequirements->isEmpty())
                            <p class="text-sm text-slate-500">Belum ada requirement.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">#</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">Nama</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">Tipe</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">Max</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600">Wajib</th>
                                            <th class="px-3 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 bg-white">
                                        @foreach($stage->documentRequirements as $req)
                                            <tr>
                                                <td class="px-3 py-2 text-sm text-slate-700">{{ $loop->iteration }}</td>
                                                <td class="px-3 py-2 text-sm">
                                                    <div class="font-semibold text-slate-900">{{ $req->document_name }}</div>
                                                    <div class="text-xs text-slate-500">{{ $req->description ?? '-' }}</div>
                                                    @if(!empty($req->template_file_path))
                                                        <div class="mt-1">
                                                            <a href="{{ Storage::url($req->template_file_path) }}" target="_blank" class="text-xs font-semibold text-indigo-700 hover:underline">
                                                                Download Template: {{ $req->template_file_name ?? 'template' }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 text-sm text-slate-700">{{ $req->document_type ?: 'Semua' }}</td>
                                                <td class="px-3 py-2 text-sm text-slate-700">{{ number_format($req->max_file_size / 1024, 1) }} MB</td>
                                                <td class="px-3 py-2 text-sm">
                                                    @if($req->is_required)
                                                        <span class="inline-flex rounded-full bg-red-500 px-2.5 py-0.5 text-xs font-semibold text-white">Wajib</span>
                                                    @else
                                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Opsional</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 text-right">
                                                    <form action="{{ route('super-admin.classes.fasilitatorDocuments.delete', [$class, $req]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus requirement ini?')" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center rounded-lg border border-rose-300 bg-white px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

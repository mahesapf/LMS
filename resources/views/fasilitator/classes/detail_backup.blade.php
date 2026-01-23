@extends('layouts.dashboard')

@section('title', 'Detail Kelas - ' . $class->name)

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Detail Kelas</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $class->name }}</p>
        </div>
        <a href="{{ route('fasilitator.classes') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Info Cards -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</p>
            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $class->activity->name ?? '-' }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Peserta</p>
            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $participants->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Max Peserta</p>
            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $class->max_participants ?? 'Unlimited' }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status</p>
            <div class="mt-2">
                @if($class->status == 'open')
                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Buka</span>
                @elseif($class->status == 'closed')
                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">Tutup</span>
                @else
                    <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Selesai</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Class Information -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Kelas</h2>
        </div>
        <div class="px-6 py-4">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Kelas</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $class->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $class->activity->name ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Max Peserta</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $class->max_participants ?? 'Unlimited' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status Kelas</dt>
                            <dd class="mt-1 text-sm">
                                @if($class->status == 'open')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Buka</span>
                                @elseif($class->status == 'closed')
                                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">Tutup</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Selesai</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            @if($class->description)
            <div class="mt-6 border-t border-slate-200 pt-6">
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Deskripsi</dt>
                <dd class="mt-2 text-sm text-slate-700">{{ $class->description }}</dd>
            </div>
            @endif
        </div>
    </div>

    <!-- Participants Section -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                Daftar Peserta ({{ $participants->count() }})
            </h2>
        </div>
        <div class="px-6 py-4">
            @if($participants->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">#</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sekolah</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Jabatan</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nilai</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($participants as $index => $participant)
                        @php
                            $grade = null;
                            if ($participant['type'] == 'kepala_sekolah') {
                                $reg = \App\Models\Registration::find($participant['registration_id']);
                                if ($reg && $reg->kepala_sekolah_user_id) {
                                    $grade = \App\Models\Grade::where('participant_id', $reg->kepala_sekolah_user_id)
                                        ->where('class_id', $class->id)
                                        ->first();
                                }
                            }
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">
                                <div class="font-semibold text-slate-900">{{ $participant['name'] }}</div>
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $participant['institution'] }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($participant['type'] == 'kepala_sekolah')
                                    <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700">Kepala Sekolah</span>
                                @else
                                    <span class="inline-flex rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-semibold text-purple-700">Guru</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $participant['email'] }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($grade)
                                    <span class="font-semibold text-emerald-700">{{ $grade->final_score }}</span>
                                    <span class="text-slate-500">({{ $grade->grade_letter }})</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('fasilitator.grades', $class) }}" class="inline-flex items-center rounded-md border border-purple-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-purple-700 hover:bg-purple-50">
                                    Input Nilai
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                Belum ada peserta di kelas ini.
            </div>
            @endif
        </div>
    </div>

    <!-- Tasks Section -->
    <div x-data="{ showAddTaskModal: false, selectedStageId: null }">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h3a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    Daftar Tugas per Tahap
                </h2>
            </div>

            @if($stages->count() > 0)
            <div class="p-6 space-y-6">
                @foreach($stages as $stage)
                <div class="rounded-lg border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <!-- Stage Header -->
                    <div class="border-b border-slate-200 bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-600 text-sm font-bold text-white">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <h3 class="font-semibold text-slate-900">{{ $stage->name }}</h3>
                                        @if($stage->description)
                                            <p class="text-sm text-slate-600">{{ $stage->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                @if($stage->start_date || $stage->end_date)
                                <div class="ml-11 mt-2 flex items-center gap-2 text-xs text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    @if($stage->start_date)
                                    {{ \Carbon\Carbon::parse($stage->start_date)->format('d/m/Y') }}
                                    @endif
                                    @if($stage->end_date)
                                    - {{ \Carbon\Carbon::parse($stage->end_date)->format('d/m/Y') }}
                                    @endif
                                </div>
                                @endif
                            </div>
                            <button 
                                @click="selectedStageId = '{{ $stage->id }}'; showAddTaskModal = true" 
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-purple-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Tugas
                            </button>
                        </div>
                    </div>

                    <!-- Tasks List -->
                    <div class="px-6 py-4">
                        @if($stage->documentRequirements->count() > 0)
                        <div class="space-y-3">
                            @foreach($stage->documentRequirements as $task)
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 transition hover:border-purple-300">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="mb-2 flex items-center gap-2">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <h5 class="font-semibold text-slate-900">{{ $task->document_name }}</h5>
                                            @if($task->is_required)
                                            <span class="inline-flex items-center rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700">Wajib</span>
                                            @else
                                            <span class="inline-flex items-center rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Opsional</span>
                                            @endif
                                        </div>
                                        <p class="mb-3 text-sm text-slate-600">{{ $task->description }}</p>
                                        <div class="flex gap-4 text-xs text-slate-500">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $task->document_type }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                Max: {{ $task->max_file_size }}KB
                                            </span>
                                        </div>
                                    </div>
                                    <form action="{{ route('fasilitator.tasks.delete', [$class, $task]) }}" method="POST" class="ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-rose-300 bg-white px-3 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="rounded-lg border border-slate-200 bg-slate-50 px-6 py-8 text-center">
                            <p class="text-sm text-slate-600">Belum ada tugas untuk tahap ini. Klik "Tambah Tugas" untuk membuat tugas baru.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-6">
                <div class="rounded-lg border border-amber-200 bg-amber-50 px-6 py-8 text-center">
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="font-medium text-amber-900">Belum Ada Tahap</p>
                    <p class="mt-1 text-sm text-amber-700">Belum ada tahap (stage) yang dibuat untuk kelas ini</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Add Task Modal -->
        <!-- Add Task Modal -->
        <div x-show="showAddTaskModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex min-h-screen items-center justify-center bg-black bg-opacity-50 px-4">
                <div @click.away="showAddTaskModal = false" class="w-full max-w-md rounded-xl bg-white shadow-xl">
                    <!-- Modal Header -->
                    <div class="border-b border-slate-200 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-slate-900">Tambah Tugas Baru</h3>
                            <button @click="showAddTaskModal = false" class="text-slate-400 hover:text-slate-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                                        @if($stage->description)
                                            <p class="text-sm text-slate-600">{{ $stage->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                @if($stage->start_date || $stage->end_date)
                                <div class="ml-11 mt-2 flex items-center gap-2 text-xs text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    @if($stage->start_date)
                                    {{ \Carbon\Carbon::parse($stage->start_date)->format('d/m/Y') }}
                                    @endif
                                    @if($stage->end_date)
                                    - {{ \Carbon\Carbon::parse($stage->end_date)->format('d/m/Y') }}
                                    @endif
                                </div>
                                @endif
                            </div>
                            <button 
                                @click="selectedStageId = '{{ $stage->id }}'; showAddTaskModal = true" 
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-purple-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Tugas
                            </button>
                        </div>
                    </div>

                    <!-- Tasks List -->
                    <div class="px-6 py-4">
                        @if($stage->documentRequirements->count() > 0)
                        <div class="space-y-3">
                            @foreach($stage->documentRequirements as $task)
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 transition hover:border-purple-300">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="mb-2 flex items-center gap-2">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <h5 class="font-semibold text-slate-900">{{ $task->document_name }}</h5>
                                            @if($task->is_required)
                                            <span class="inline-flex items-center rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700">Wajib</span>
                                            @else
                                            <span class="inline-flex items-center rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Opsional</span>
                                            @endif
                                        </div>
                                        <p class="mb-3 text-sm text-slate-600">{{ $task->description }}</p>
                                        <div class="flex gap-4 text-xs text-slate-500">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $task->document_type }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                Max: {{ $task->max_file_size }}KB
                                            </span>
                                        </div>
                                    </div>
                                    <form action="{{ route('fasilitator.tasks.delete', [$class, $task]) }}" method="POST" class="ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-rose-300 bg-white px-3 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="rounded-lg border border-slate-200 bg-slate-50 px-6 py-8 text-center">
                            <p class="text-sm text-slate-600">Belum ada tugas untuk tahap ini. Klik "Tambah Tugas" untuk membuat tugas baru.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-6">
                <div class="rounded-lg border border-amber-200 bg-amber-50 px-6 py-8 text-center">
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="font-medium text-amber-900">Belum Ada Tahap</p>
                    <p class="mt-1 text-sm text-amber-700">Belum ada tahap (stage) yang dibuat untuk kelas ini</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Add Task Modal -->
        <div x-show="showAddTaskModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex min-h-screen items-center justify-center bg-black bg-opacity-50 px-4">
                <div @click.away="showAddTaskModal = false" class="w-full max-w-md rounded-xl bg-white shadow-xl">
                    <!-- Modal Header -->
                    <div class="border-b border-slate-200 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-slate-900">Tambah Tugas Baru</h3>
                            <button @click="showAddTaskModal = false" class="text-slate-400 hover:text-slate-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('fasilitator.tasks.store', $class) }}" method="POST" class="px-6 py-4 space-y-4">
                        @csrf
                        <input type="hidden" name="stage_id" x-model="selectedStageId">
                        
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Nama Tugas <span class="text-rose-600">*</span></label>
                            <input type="text" name="document_name" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200" placeholder="e.g., Laporan Akhir Pelatihan">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Tipe Dokumen <span class="text-rose-600">*</span></label>
                            <input type="text" name="document_type" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200" placeholder="e.g., PDF, Word, Excel">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200" placeholder="Jelaskan detail tugas yang harus dikerjakan"></textarea>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-700">Max Ukuran (KB)</label>
                                <input type="number" name="max_file_size" value="5120" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-700">Status</label>
                                <select name="is_required" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200">
                                    <option value="1">Wajib</option>
                                    <option value="0">Opsional</option>
                                </select>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center gap-3 border-t border-slate-200 pt-4">
                            <button type="button" @click="showAddTaskModal = false" class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2 font-semibold text-slate-700 transition hover:bg-slate-50">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 rounded-lg bg-purple-600 px-4 py-2 font-semibold text-white transition hover:bg-purple-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 inline h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Simpan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

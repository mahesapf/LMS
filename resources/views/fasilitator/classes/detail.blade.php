@extends('layouts.dashboard')

@section('title', 'Detail Kelas - ' . $class->name)

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'participants' }">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('fasilitator.classes') }}" class="text-sky-600 hover:text-sky-700">Kelas Saya</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <span class="text-slate-600">{{ $class->name }}</span>
    </div>

    <!-- Header -->
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-semibold text-slate-900">{{ $class->name }}</h1>
            <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">{{ $class->code ?? 'CLS-' . $class->id }}</span>
        </div>
        <p class="mt-1 text-sm text-slate-500">Kelola peserta, tugas, dan dokumen kelas.</p>
    </div>

    <!-- Class Info Summary -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="grid divide-x divide-slate-200 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Peserta -->
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    <p class="text-xs font-medium text-slate-500">Total Peserta</p>
                </div>
                <p class="text-sm font-semibold text-slate-900">{{ $participants->count() }} Orang</p>
            </div>

            <!-- Kapasitas -->
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                    </svg>
                    <p class="text-xs font-medium text-slate-500">Kapasitas Kelas</p>
                </div>
                <p class="text-sm font-semibold text-slate-900">{{ $class->max_participants ?? 'Tidak Terbatas' }}</p>
            </div>

            <!-- Total Tugas -->
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h3a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-xs font-medium text-slate-500">Total Tugas</p>
                </div>
                <p class="text-sm font-semibold text-slate-900">{{ $stages->sum(fn($s) => $s->documentRequirements->count()) }} Dokumen</p>
            </div>

            <!-- Status Kelas -->
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    @if($class->status == 'open')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @elseif($class->status == 'closed')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                        </svg>
                    @endif
                    <p class="text-xs font-medium text-slate-500">Status Kelas</p>
                </div>
                @if($class->status == 'open')
                    <p class="text-sm font-semibold text-slate-900">Buka</p>
                @elseif($class->status == 'closed')
                    <p class="text-sm font-semibold text-slate-900">Tutup</p>
                @else
                    <p class="text-sm font-semibold text-slate-900">Selesai</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-slate-200">
        <nav class="-mb-px flex space-x-6">
            <button @click="activeTab = 'participants'"
                    :class="activeTab === 'participants' ? 'border-sky-500 text-sky-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                    class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                Peserta
            </button>
            <button @click="activeTab = 'tasks'"
                    :class="activeTab === 'tasks' ? 'border-sky-500 text-sky-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                    class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h3a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
                Tugas
            </button>
            <button @click="activeTab = 'documents'"
                    :class="activeTab === 'documents' ? 'border-sky-500 text-sky-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                    class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
                Dokumen
            </button>
        </nav>
    </div>

    <!-- Tab Content: Participants -->
    <div x-show="activeTab === 'participants'" x-cloak class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Daftar Peserta</h2>
                <p class="mt-1 text-sm text-slate-500">Total: {{ $participants->count() }} peserta</p>
            </div>
            <a href="{{ route('fasilitator.grades', $class) }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Input Nilai
            </a>
        </div>
        <div class="px-6 py-4">
            @if($participants->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Sekolah</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Jabatan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($participants as $index => $participant)
                        @php
                            $grade = null;
                            if (isset($participant['user_id']) && $participant['user_id']) {
                                // Get grade for this participant
                                $grade = \App\Models\Grade::where('participant_id', $participant['user_id'])
                                    ->where('class_id', $class->id)
                                    ->first();
                            }
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-slate-900">{{ $participant['name'] }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $participant['institution'] }}</td>
                            <td class="px-4 py-3">
                                @if($participant['type'] == 'kepala_sekolah')
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-semibold text-amber-700">Kepala Sekolah</span>
                                            <span class="text-[10px] text-amber-600">Pimpinan</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-semibold text-teal-700">Guru</span>
                                            <span class="text-[10px] text-teal-600">Tenaga Pendidik</span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $participant['email'] }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($grade)
                                    <span class="font-semibold text-emerald-700">{{ $grade->final_score }}</span>
                                    <span class="text-slate-500">({{ $grade->grade_letter }})</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="rounded-lg border border-slate-200 bg-slate-50 px-6 py-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="mt-3 text-sm text-slate-600">Belum ada peserta di kelas ini.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tab Content: Tasks -->
    <div x-show="activeTab === 'tasks'" x-cloak x-data="{ showAddTaskModal: false, selectedStageId: null }">
        <!-- Header dengan tombol Lihat Pengumpulan -->
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm mb-6">
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Daftar Tugas</h2>
                    <p class="mt-1 text-sm text-slate-500">Total: {{ $stages->sum(fn($s) => $s->documentRequirements->count()) }} tugas</p>
                </div>
                <a href="{{ route('fasilitator.tasks.submissions', $class) }}" class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white hover:bg-purple-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" />
                        <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                    </svg>
                    Lihat Pengumpulan
                </a>
            </div>
        </div>

        <div class="space-y-6">
            @if($stages->count() > 0)
                @foreach($stages as $stage)
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 bg-gradient-to-r from-sky-50 to-blue-50 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-600 text-sm font-bold text-white">
                                    {{ $loop->iteration }}
                                </span>
                                <div>
                                    <h3 class="font-semibold text-slate-900">{{ $stage->name }}</h3>
                                    @if($stage->description)
                                        <p class="text-sm text-slate-600">{{ $stage->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <button
                                @click="selectedStageId = '{{ $stage->id }}'; showAddTaskModal = true"
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($stage->documentRequirements->count() > 0)
                        <div class="space-y-3">
                            @foreach($stage->documentRequirements as $task)
                            <div class="flex items-start justify-between rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h5 class="font-semibold text-slate-900">{{ $task->document_name }}</h5>
                                        @if($task->is_required)
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-rose-700">Wajib</span>
                                                    <span class="text-[10px] text-rose-600">Harus Upload</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-slate-700">Opsional</span>
                                                    <span class="text-[10px] text-slate-600">Tidak Wajib</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-sm text-slate-600">{{ $task->description }}</p>
                                    <div class="mt-2 flex gap-4 text-xs text-slate-500">
                                        <span>{{ $task->document_type }}</span>
                                        <span>Max: {{ $task->max_file_size }}KB</span>
                                    </div>
                                </div>
                                <form action="{{ route('fasilitator.tasks.delete', [$class, $task]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 rounded-lg border border-rose-300 bg-white px-3 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="rounded-lg border border-slate-200 bg-slate-50 px-6 py-8 text-center">
                            <p class="text-sm text-slate-600">Belum ada tugas untuk tahap ini.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-8 text-center">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="font-semibold text-amber-900">Belum Ada Tahap</p>
                <p class="mt-1 text-sm text-amber-700">Belum ada tahap (stage) yang dibuat untuk kelas ini</p>
            </div>
            @endif
        </div>

        <!-- Add Task Modal -->
        <div x-show="showAddTaskModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex min-h-screen items-center justify-center bg-black bg-opacity-50 px-4">
                <div @click.away="showAddTaskModal = false" class="w-full max-w-md rounded-xl bg-white shadow-xl">
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
                    <form action="{{ route('fasilitator.tasks.store', $class) }}" method="POST" class="px-6 py-4 space-y-4">
                        @csrf
                        <input type="hidden" name="stage_id" x-model="selectedStageId">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Nama Tugas <span class="text-rose-600">*</span></label>
                            <input type="text" name="document_name" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Tipe Dokumen <span class="text-rose-600">*</span></label>
                            <select name="document_type" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                <option value="">Pilih Tipe Dokumen</option>
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
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"></textarea>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-700">Max Ukuran (KB)</label>
                                <input type="number" name="max_file_size" value="5120" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-700">Status</label>
                                <select name="is_required" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value="1">Wajib</option>
                                    <option value="0">Opsional</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 border-t border-slate-200 pt-4">
                            <button type="button" @click="showAddTaskModal = false" class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2 font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                            <button type="submit" class="flex-1 rounded-lg bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content: Documents -->
    <div x-show="activeTab === 'documents'" x-cloak>
        <div class="space-y-6">
            <!-- General Documents -->
            @if($fasilitatorGeneralRequirements->count() > 0)
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="font-semibold text-slate-900">Dokumen Umum</h3>
                    <p class="mt-1 text-sm text-slate-500">Dokumen yang diminta tanpa tahap tertentu</p>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($fasilitatorGeneralRequirements as $req)
                            @php $uploaded = $req->documents->first(); @endphp
                            <div class="flex items-start justify-between rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <div class="flex-1">
                                    <h5 class="font-semibold text-slate-900">{{ $req->document_name }}</h5>
                                    <p class="mt-1 text-sm text-slate-600">{{ $req->description ?? '-' }}</p>
                                    @if(!empty($req->template_file_path))
                                        <a href="{{ Storage::url($req->template_file_path) }}" target="_blank" class="mt-2 inline-flex items-center text-xs font-semibold text-sky-700 hover:underline">
                                            Download Template
                                        </a>
                                    @endif
                                    <div class="mt-2">
                                        @if($uploaded)
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-emerald-700">Sudah Upload</span>
                                                    <span class="text-[10px] text-emerald-600">Tersimpan</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-amber-700">Belum Upload</span>
                                                    <span class="text-[10px] text-amber-600">Menunggu</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4 flex gap-2">
                                    @if($uploaded)
                                        <a href="{{ Storage::url($uploaded->file_path) }}" target="_blank" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat</a>
                                    @endif
                                    <label for="modal-upload-fasilitator-{{ $req->id }}" class="cursor-pointer rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                                        {{ $uploaded ? 'Ganti' : 'Upload' }}
                                    </label>
                                </div>
                            </div>

                            <input type="checkbox" id="modal-upload-fasilitator-{{ $req->id }}" class="modal-toggle" />
                            <div class="modal">
                                <div class="modal-box relative max-w-lg">
                                    <label for="modal-upload-fasilitator-{{ $req->id }}" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                                    <h3 class="font-bold text-lg mb-4">Upload {{ $req->document_name }}</h3>
                                    @if(!empty($req->template_file_path))
                                        <div class="mb-4">
                                            <a href="{{ Storage::url($req->template_file_path) }}" target="_blank" class="text-xs font-semibold text-sky-700 hover:underline">Download Template: {{ $req->template_file_name ?? 'template' }}</a>
                                        </div>
                                    @endif
                                    <form action="{{ route('fasilitator.documents.upload-required') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="document_requirement_id" value="{{ $req->id }}">
                                        <input type="hidden" name="class_id" value="{{ $class->id }}">
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
                                            <textarea name="notes" rows="3" class="textarea textarea-bordered"></textarea>
                                        </div>
                                        @if($uploaded)
                                            <div class="alert alert-warning mb-4">
                                                <span>File yang sudah ada akan diganti dengan file baru.</span>
                                            </div>
                                        @endif
                                        <div class="modal-action">
                                            <label for="modal-upload-fasilitator-{{ $req->id }}" class="btn btn-ghost">Batal</label>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Stage Documents -->
            @foreach($stages as $stage)
                @php $reqs = $fasilitatorRequirementsByStage->get($stage->id, collect()); @endphp
                @if($reqs->isNotEmpty())
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 bg-gradient-to-r from-sky-50 to-blue-50 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-600 text-sm font-bold text-white">
                                {{ $loop->iteration }}
                            </span>
                            <div>
                                <h3 class="font-semibold text-slate-900">{{ $stage->name }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($reqs as $req)
                                @php $uploaded = $req->documents->first(); @endphp
                                <div class="flex items-start justify-between rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-slate-900">{{ $req->document_name }}</h5>
                                        <p class="mt-1 text-sm text-slate-600">{{ $req->description ?? '-' }}</p>
                                        @if(!empty($req->template_file_path))
                                            <a href="{{ Storage::url($req->template_file_path) }}" target="_blank" class="mt-2 inline-flex items-center text-xs font-semibold text-sky-700 hover:underline">
                                                Download Template
                                            </a>
                                        @endif
                                        <div class="mt-2">
                                            @if($uploaded)
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-semibold text-emerald-700">Sudah Upload</span>
                                                        <span class="text-[10px] text-emerald-600">Tersimpan</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-semibold text-amber-700">Belum Upload</span>
                                                        <span class="text-[10px] text-amber-600">Menunggu</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-4 flex gap-2">
                                        @if($uploaded)
                                            <a href="{{ Storage::url($uploaded->file_path) }}" target="_blank" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat</a>
                                        @endif
                                        <label for="modal-upload-fasilitator-stage-{{ $req->id }}" class="cursor-pointer rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                                            {{ $uploaded ? 'Ganti' : 'Upload' }}
                                        </label>
                                    </div>
                                </div>

                                <input type="checkbox" id="modal-upload-fasilitator-stage-{{ $req->id }}" class="modal-toggle" />
                                <div class="modal">
                                    <div class="modal-box relative max-w-lg">
                                        <label for="modal-upload-fasilitator-stage-{{ $req->id }}" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                                        <h3 class="font-bold text-lg mb-4">Upload {{ $req->document_name }}</h3>
                                        @if(!empty($req->template_file_path))
                                            <div class="mb-4">
                                                <a href="{{ Storage::url($req->template_file_path) }}" target="_blank" class="text-sm font-semibold text-sky-700 hover:underline">Download Template: {{ $req->template_file_name ?? 'template' }}</a>
                                            </div>
                                        @endif
                                        <form action="{{ route('fasilitator.documents.upload-required') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="document_requirement_id" value="{{ $req->id }}">
                                            <input type="hidden" name="class_id" value="{{ $class->id }}">
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
                                                <textarea name="notes" rows="3" class="textarea textarea-bordered"></textarea>
                                            </div>
                                            @if($uploaded)
                                                <div class="alert alert-warning mb-4">
                                                    <span>File yang sudah ada akan diganti dengan file baru.</span>
                                                </div>
                                            @endif
                                            <div class="modal-action">
                                                <label for="modal-upload-fasilitator-stage-{{ $req->id }}" class="btn btn-ghost">Batal</label>
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endforeach

            @if($fasilitatorGeneralRequirements->isEmpty() && $fasilitatorRequirementsByStage->flatten()->isEmpty())
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-3 text-sm text-slate-600">Belum ada dokumen yang diminta.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

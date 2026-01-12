@extends('layouts.dashboard')

@section('title', 'Detail Kelas')

@section('sidebar')
    @include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header & Overview -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Detail Kelas</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $class->name }}</p>
        </div>
        <a href="{{ route($routePrefix . '.classes.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
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
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kapasitas</p>
            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $class->capacity }} peserta</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Peserta Terdaftar</p>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-lg font-semibold text-slate-900">{{ $class->participantMappings->count() }}</span>
                <span class="text-sm text-slate-500">/ {{ $class->capacity }}</span>
            </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status</p>
            <div class="mt-2">
                @if($class->status == 'active')
                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Aktif</span>
                @elseif($class->status == 'completed')
                    <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Selesai</span>
                @else
                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">Pending</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Class Details -->
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
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Kelas</dt>
                            <dd class="mt-1 text-sm text-slate-900">
                                @if($class->start_date && $class->end_date)
                                    {{ $class->start_date->format('d F Y') }} s/d {{ $class->end_date->format('d F Y') }}
                                @elseif($class->activity && $class->activity->start_date && $class->activity->end_date)
                                    {{ $class->activity->start_date->format('d F Y') }} s/d {{ $class->activity->end_date->format('d F Y') }}
                                    <span class="text-xs text-slate-500">(Mengikuti kegiatan)</span>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Durasi</dt>
                            <dd class="mt-1 text-sm text-slate-900">
                                @if($class->start_date && $class->end_date)
                                    {{ $class->start_date->diffInDays($class->end_date) + 1 }} hari
                                @elseif($class->activity && $class->activity->start_date && $class->activity->end_date)
                                    {{ $class->activity->start_date->diffInDays($class->activity->end_date) + 1 }} hari
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Dibuat Oleh</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $class->creator->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $class->activity->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Program</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ $class->activity->program->name ?? '-' }}</dd>
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

    <!-- Stages Section -->
    @if($class->stages->count() > 0)
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Tahap Kegiatan ({{ $class->stages->count() }})
            </h2>
        </div>
        <div class="px-6 py-4">
            <div class="space-y-4">
                @foreach($class->stages as $stage)
                <div class="rounded-lg border {{ $stage->status == 'ongoing' ? 'border-blue-300 bg-blue-50' : ($stage->status == 'completed' ? 'border-green-300 bg-green-50' : 'border-slate-200 bg-white') }} p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full {{ $stage->status == 'ongoing' ? 'bg-blue-600 text-white' : ($stage->status == 'completed' ? 'bg-green-600 text-white' : 'bg-slate-300 text-slate-700') }} text-sm font-semibold">
                                    {{ $stage->order }}
                                </span>
                                <div>
                                    <h3 class="font-semibold text-slate-900">{{ $stage->name }}</h3>
                                    @if($stage->description)
                                        <p class="mt-1 text-sm text-slate-600">{{ $stage->description }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 ml-11 grid gap-3 sm:grid-cols-2">
                                @if($stage->start_date || $stage->end_date)
                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>
                                        @if($stage->start_date && $stage->end_date)
                                            {{ $stage->start_date->format('d M Y') }} - {{ $stage->end_date->format('d M Y') }}
                                        @elseif($stage->start_date)
                                            Mulai: {{ $stage->start_date->format('d M Y') }}
                                        @elseif($stage->end_date)
                                            Selesai: {{ $stage->end_date->format('d M Y') }}
                                        @endif
                                    </span>
                                </div>
                                @endif

                                <div class="flex items-center gap-2">
                                    @if($stage->status == 'not_started')
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Belum Dimulai
                                        </span>
                                    @elseif($stage->status == 'ongoing')
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Sedang Berjalan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Participants Section -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                Daftar Peserta
            </h2>
            <button type="button" onclick="document.getElementById('assignModal').showModal()" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Peserta
            </button>
        </div>
        <div class="px-6 py-4">
            @if(session('success'))
                <div class="mb-4 border-l-4 border-emerald-600 bg-emerald-50 p-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 border-l-4 border-red-600 bg-red-50 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if($teacherParticipants->isEmpty())
                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    Belum ada peserta di kelas ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">#</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Peserta</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sekolah</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Jabatan</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kecamatan</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($teacherParticipants as $index => $participant)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">
                                    <div class="text-sm font-semibold text-slate-900">{{ $participant['nama_lengkap'] }}</div>
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $participant['nama_sekolah'] ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $participant['jabatan'] }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $participant['email'] ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $participant['kecamatan'] ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">
                                    @if($participant['status'] == 'validated')
                                        Tervalidasi
                                    @elseif($participant['status'] == 'approved')
                                        Disetujui
                                    @else
                                        {{ ucfirst($participant['status']) }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right">
                                    @if($participant['is_kepala_sekolah'])
                                        <form action="{{ route($routePrefix . '.classes.removeKepalaSekolah', [$class, $participant['registration_id']]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-rose-700" onclick="return confirm('Yakin ingin mengeluarkan {{ $participant['nama_lengkap'] }} dari kelas?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 10a1 1 0 011-1h.01a1 1 0 110 2H5a1 1 0 01-1-1zm11-7a1 1 0 100-2 1 1 0 000 2zM13.03 7.03a1 1 0 00-1.414-1.414l-.707.707V4a1 1 0 10-2 0v2.323l-.707-.707a1 1 0 00-1.414 1.414l2.121 2.121a1 1 0 001.414 0l2.121-2.121z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route($routePrefix . '.classes.removeTeacherParticipant', [$class, $participant['teacher_id']]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-rose-700" onclick="return confirm('Yakin ingin mengeluarkan {{ $participant['nama_lengkap'] }} dari kelas?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 10a1 1 0 011-1h.01a1 1 0 110 2H5a1 1 0 01-1-1zm11-7a1 1 0 100-2 1 1 0 000 2zM13.03 7.03a1 1 0 00-1.414-1.414l-.707.707V4a1 1 0 10-2 0v2.323l-.707-.707a1 1 0 00-1.414 1.414l2.121 2.121a1 1 0 001.414 0l2.121-2.121z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Fasilitator Section -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.5 1.5H5.75A2.75 2.75 0 003 4.25v11.5A2.75 2.75 0 005.75 18.5h8.5a2.75 2.75 0 002.75-2.75V6.5m-13-5h10m-10 4h10m-10 4h10m-10 4h6" />
                </svg>
                Daftar Fasilitator
            </h2>
            <button type="button" onclick="document.getElementById('assignFasilitatorModal').showModal()" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Fasilitator
            </button>
        </div>
        <div class="px-6 py-4">
            @if($class->fasilitatorMappings->where('status', 'in')->isEmpty())
                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    Belum ada fasilitator di kelas ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">#</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Fasilitator</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">No. HP</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Ditambahkan</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($class->fasilitatorMappings->where('status', 'in') as $index => $mapping)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 text-sm text-slate-900">{{ $mapping->fasilitator->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->fasilitator->email ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->fasilitator->phone ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->assigned_date ? \Carbon\Carbon::parse($mapping->assigned_date)->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route($routePrefix . '.classes.removeFasilitator', [$class, $mapping]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-rose-700" onclick="return confirm('Yakin ingin mengeluarkan {{ $mapping->fasilitator->name ?? 'fasilitator ini' }} dari kelas?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 10a1 1 0 011-1h.01a1 1 0 110 2H5a1 1 0 01-1-1zm11-7a1 1 0 100-2 1 1 0 000 2zM13.03 7.03a1 1 0 00-1.414-1.414l-.707.707V4a1 1 0 10-2 0v2.323l-.707-.707a1 1 0 00-1.414 1.414l2.121 2.121a1 1 0 001.414 0l2.121-2.121z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
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

    <!-- Admin Section -->
    @php
        $activeAdmins = $class->activity->adminMappings->where('status', 'active')->where('activity_id', $class->activity_id);
    @endphp
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                Admin yang Ditugaskan
            </h2>
            <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">
                {{ $activeAdmins->count() }} Admin
            </span>
        </div>
        <div class="px-6 py-4">
            @if($activeAdmins->isEmpty())
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    Belum ada admin yang ditugaskan untuk kegiatan ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">#</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Admin</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">No. HP</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Instansi</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Ditugaskan</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($activeAdmins as $index => $mapping)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">
                                    <div class="text-sm font-semibold text-slate-900">{{ $mapping->admin->name ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->admin->email ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->admin->phone ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->admin->instansi ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">
                                    {{ $mapping->assigned_date ? \Carbon\Carbon::parse($mapping->assigned_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Aktif</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Assign Peserta -->
<dialog id="assignModal" class="modal">
  <div class="modal-box max-w-2xl">
    <div class="flex items-center justify-between mb-4">
        <h5 class="text-lg font-semibold text-slate-900">Tambah Peserta ke Kelas</h5>
        <button type="button" onclick="document.getElementById('assignModal').close()" class="btn btn-sm btn-circle btn-ghost">✕</button>
    </div>

    <form id="filterForm" class="space-y-3 mb-4">
        <div>
            <label for="filter-kecamatan" class="block text-sm font-medium text-slate-700">Filter Kecamatan</label>
            <div class="mt-1 flex gap-2">
                <select name="kecamatan" id="filter-kecamatan" class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatanOptions as $kecamatan)
                        <option value="{{ $kecamatan }}" {{ $selectedKecamatan == $kecamatan ? 'selected' : '' }}>
                            {{ $kecamatan }}
                        </option>
                    @endforeach
                </select>
                <button type="button" onclick="applyKecamatanFilter()" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Terapkan</button>
            </div>
            <p class="mt-1 text-xs text-slate-500">Menampilkan peserta tervalidasi yang belum masuk kelas pada kegiatan ini.</p>
        </div>
    </form>

    @if($selectedKecamatan)
        @if($availableRegistrations->isEmpty())
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                <p>Tidak ada peserta yang tersedia untuk ditambahkan di kecamatan <strong>{{ $selectedKecamatan }}</strong>.</p>
            </div>
        @else
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                <h6 class="mb-3 text-sm font-semibold text-slate-900">Pendaftaran yang akan ditambahkan:</h6>
                <div class="mb-4 max-h-80 overflow-y-auto space-y-2">
                    @foreach($availableRegistrations as $registration)
                        <div class="flex items-start gap-3 rounded-lg border border-slate-200 bg-white p-3">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-900">{{ $registration->nama_sekolah ?? '-' }}</p>
                                <p class="text-xs text-slate-500">{{ $registration->email ?? '-' }}</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    📍 {{ $registration->kecamatan ?? '-' }}
                                </p>
                                <p class="text-xs text-slate-600 mt-1">
                                    @if($registration->jumlah_peserta > 0)
                                        {{ $registration->jumlah_peserta }} peserta
                                    @else
                                        {{ $registration->jumlah_guru + $registration->jumlah_kepala_sekolah }} peserta ({{ $registration->jumlah_guru }} Guru + {{ $registration->jumlah_kepala_sekolah }} Kepala Sekolah)
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 mb-4">
                    <p class="text-sm text-emerald-800">
                        <strong>{{ $availableRegistrations->count() }}</strong> pendaftaran siap ditambahkan ke kelas ini.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <button type="button" onclick="document.getElementById('assignModal').close()" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                    <form method="POST" action="{{ route($routePrefix . '.classes.assignParticipantsByKecamatan', $class) }}" class="inline">
                        @csrf
                        <input type="hidden" name="kecamatan" value="{{ $selectedKecamatan }}">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            Tambahkan Semua Pendaftaran
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
            <p>Silakan pilih kecamatan di atas untuk melihat pendaftaran yang tersedia.</p>
        </div>
    @endif
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<!-- Modal Assign Fasilitator -->
<dialog id="assignFasilitatorModal" class="modal">
  <div class="modal-box max-w-lg">
    <div class="flex items-center justify-between mb-4">
        <h5 class="text-lg font-semibold text-slate-900">Tambah Fasilitator ke Kelas</h5>
        <button type="button" onclick="document.getElementById('assignFasilitatorModal').close()" class="btn btn-sm btn-circle btn-ghost">✕</button>
    </div>

    <form action="{{ route($routePrefix . '.classes.assignFasilitator', $class) }}" method="POST">
        @csrf

        @if($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3">
                <ul class="space-y-1 text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($availableFasilitators->isEmpty())
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-3 text-sm text-amber-800">
                Tidak ada fasilitator yang tersedia untuk ditambahkan.
            </div>
        @else
            <div class="mb-4">
                <label for="fasilitator_id" class="block text-sm font-medium text-slate-700">Pilih Fasilitator <span class="text-red-600">*</span></label>
                <select class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('fasilitator_id') border-red-500 @enderror" id="fasilitator_id" name="fasilitator_id" required>
                    <option value="">-- Pilih Fasilitator --</option>
                    @foreach($availableFasilitators as $fasilitator)
                        <option value="{{ $fasilitator->id }}">
                            {{ $fasilitator->name }} - {{ $fasilitator->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="rounded-lg border border-blue-200 bg-blue-50 p-3 text-xs text-blue-800">
                Hanya fasilitator yang aktif dan belum ditugaskan di kelas ini yang ditampilkan.
            </div>
        @endif

        <div class="modal-action mt-4">
            <button type="button" onclick="document.getElementById('assignFasilitatorModal').close()" class="btn btn-outline">Batal</button>
            @if(!$availableFasilitators->isEmpty())
                <button type="submit" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambahkan
                </button>
            @endif
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<script>
function applyKecamatanFilter() {
    const kecamatan = document.getElementById('filter-kecamatan').value;
    if (!kecamatan) {
        alert('Silakan pilih kecamatan terlebih dahulu');
        return;
    }

    // Simpan status bahwa modal harus tetap terbuka
    sessionStorage.setItem('openAssignModal', 'true');
    sessionStorage.setItem('selectedKecamatan', kecamatan);

    // Redirect dengan parameter kecamatan
    const url = new URL(window.location.href);
    url.searchParams.set('kecamatan', kecamatan);
    window.location.href = url.toString();
}

// Saat halaman selesai loading, buka modal jika diperlukan
window.addEventListener('load', function() {
    if (sessionStorage.getItem('openAssignModal') === 'true') {
        setTimeout(() => {
            const modal = document.getElementById('assignModal');
            if (modal) {
                modal.showModal();
                sessionStorage.removeItem('openAssignModal');
                sessionStorage.removeItem('selectedKecamatan');
            }
        }, 100);
    }
});

document.addEventListener('alpine:init', () => {
    if (!Alpine.store('assign')) {
        Alpine.store('assign', { open: false });
    }
});
</script>
@endsection

